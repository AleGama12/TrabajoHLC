<?php
// Incluir la función de conexión a la base de datos
require_once("funcionesBD.php");

// Obtener la conexión
$conexion = obtenerConexion();

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Inicializar el listado de empresas
$empresas = [];

// Verificar si se ha enviado el formulario con el id de la empresa a buscar
if (isset($_POST['btnBuscarEmpresa'])) {
    $id_empresa = $_POST['txtId']; // Obtener el id de la empresa desde el formulario

    // Consulta SQL para obtener la empresa con el id especificado
    $sql = "SELECT id_empresa, nombre, sector, ubicacion, email, telefono FROM Empresas WHERE id_empresa = ?";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_empresa); // Vincular el parámetro de id de la empresa
    $stmt->execute();
    
    // Obtener los resultados
    $resultado = $stmt->get_result();
    
    // Verificar si se encontraron resultados
    if ($resultado->num_rows > 0) {
        // Almacenar los resultados en el array $empresas
        while ($fila = $resultado->fetch_assoc()) {
            $empresas[] = $fila;
        }
    } else {
        $mensaje = "No se encontró la empresa con el ID " . $id_empresa . ".";
    }
    
    // Cerrar la declaración
    $stmt->close();
}

// Incluir la cabecera HTML
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <!-- Formulario de búsqueda -->
        <form id="frmBuscarEmpresa" class="form-horizontal" action="buscar_empresa.php" method="post">
            <fieldset>
                <legend>Buscar Empresa</legend>
                <div class="form-group">
                    <label for="txtId" class="col-xs-4 control-label">ID de la Empresa:</label>
                    <div class="col-xs-4">
                        <input type="text" id="txtId" name="txtId" class="form-control input-md" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4">
                        <button type="submit" name="btnBuscarEmpresa" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- Mostrar las empresas encontradas -->
        <?php if (!empty($empresas)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Sector</th>
                        <th>Ubicación</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empresas as $empresa): ?>
                        <tr>
                            <td><?php echo $empresa['id_empresa']; ?></td>
                            <td><?php echo $empresa['nombre']; ?></td>
                            <td><?php echo $empresa['sector']; ?></td>
                            <td><?php echo $empresa['ubicacion']; ?></td>
                            <td><?php echo $empresa['email']; ?></td>
                            <td><?php echo $empresa['telefono']; ?></td>
                            <td>
                                <!-- Botón para modificar los datos de la empresa -->
                                <a href="modificar_empresa.php?id=<?php echo $empresa['id_empresa']; ?>" class="btn btn-warning">Modificar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($mensaje)): ?>
            <div class="alert alert-warning">
                <p><?php echo $mensaje; ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

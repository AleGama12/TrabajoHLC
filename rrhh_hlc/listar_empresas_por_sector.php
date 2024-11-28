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

// Verificar si se ha enviado el formulario con el sector
if (isset($_POST['btnListadoEmpresasParam'])) {
    $sector = $_POST['txtSector']; // Obtener el sector desde el formulario

    // Consulta SQL para obtener empresas del sector introducido
    $sql = "SELECT id_empresa, nombre, sector, ubicacion, email, telefono FROM Empresas WHERE sector = ?";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $sector); // Vincular el parámetro del sector
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
        $mensaje = "No se encontraron empresas en el sector \"" . htmlspecialchars($sector) . "\".";
    }
    
    // Cerrar la declaración
    $stmt->close();
}

// Incluir la cabecera HTML
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <!-- Formulario para obtener el listado de empresas por sector -->
        <form class="form-horizontal" action="listar_empresas_por_sector.php" name="frmListadoEmpresasParam" id="frmListadoEmpresasParam" method="post">
            <fieldset>
                <legend>Listado de Empresas por Sector</legend>

                <!-- Campo de sector -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtSector">Sector</label>
                    <div class="col-xs-4">
                        <input id="txtSector" name="txtSector" placeholder="Sector empresarial" class="form-control input-md" type="text" required>
                    </div>
                </div>

                <!-- Botón para obtener el listado de empresas -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnListadoEmpresasParam"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnListadoEmpresasParam" name="btnListadoEmpresasParam" class="btn btn-primary" value="Listado de las empresas">
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- Mostrar la tabla con las empresas si se encontraron resultados -->
        <?php if (!empty($empresas)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Sector</th>
                        <th>Ubicacion</th>
                        <th>Email</th>
                        <th>Teléfono</th>
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

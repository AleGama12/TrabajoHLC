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

// Verificar si se ha presionado el botón para ver el listado
if (isset($_POST['btnVerListado'])) {
    // Consulta SQL para obtener todas las empresas
    $sql = "SELECT id_empresa, nombre, sector, ubicacion, email, telefono FROM Empresas";
    $resultado = $conexion->query($sql);

    // Verificar si la consulta se ejecutó correctamente
    if ($resultado->num_rows > 0) {
        // Si hay resultados, almacenarlos en el array $empresas
        while ($fila = $resultado->fetch_assoc()) {
            $empresas[] = $fila;
        }
    } else {
        $mensaje = "No se encontraron empresas en la base de datos.";
    }
}

// Incluir la cabecera HTML
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <!-- Formulario para mostrar listado de empresas -->
        <form class="form-horizontal" action="listar_empresas.php" name="frmListadoEmpresas" id="frmListadoEmpresas" method="post">
            <fieldset>
                <legend>Listado de Empresas</legend>

                <!-- Botón para obtener el listado de empresas -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnVerListado"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnVerListado" name="btnVerListado" class="btn btn-primary" value="Aceptar Listado" />
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- Tabla con el listado de empresas si existen resultados -->
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

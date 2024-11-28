<?php
// Incluir la función de conexión a la base de datos
require_once("funcionesBD.php");

// Obtener la conexión
$conexion = obtenerConexion();

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Inicializar el listado de candidatos
$candidatos = [];

// Verificar si se ha presionado el botón para ver el listado
if (isset($_POST['btnVerListado'])) {
    // Consulta SQL para obtener todos los candidatos
    $sql = "SELECT id_candidato, nombre, experiencia, direccion, contacto FROM Candidatos";
    $resultado = $conexion->query($sql);

    // Verificar si la consulta se ejecutó correctamente
    if ($resultado->num_rows > 0) {
        // Si hay resultados, almacenarlos en el array $candidatos
        while ($fila = $resultado->fetch_assoc()) {
            $candidatos[] = $fila;
        }
    } else {
        $mensaje = "No se encontraron candidatos en la base de datos.";
    }
}

// Incluir la cabecera HTML
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <!-- Formulario para mostrar listado de candidatos -->
        <form class="form-horizontal" action="listar_candidatos.php" name="frmListadoCandidatos" id="frmListadoCandidatos" method="post">
            <fieldset>
                <legend>Listado de Candidatos</legend>

                <!-- Botón para obtener el listado de candidatos -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnVerListado"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnVerListado" name="btnVerListado" class="btn btn-primary" value="Aceptar Listado" />
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- Tabla con el listado de candidatos si existen resultados -->
        <?php if (!empty($candidatos)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Experiencia</th>
                        <th>Dirección</th>
                        <th>Contacto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatos as $candidato): ?>
                        <tr>
                            <td><?php echo $candidato['id_candidato']; ?></td>
                            <td><?php echo $candidato['nombre']; ?></td>
                            <td><?php echo $candidato['experiencia']; ?></td>
                            <td><?php echo $candidato['direccion']; ?></td>
                            <td><?php echo $candidato['contacto']; ?></td>
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

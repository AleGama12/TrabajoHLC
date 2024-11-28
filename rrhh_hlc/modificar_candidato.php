<?php
// Incluir la función de conexión a la base de datos
require_once("funcionesBD.php");

// Obtener la conexión
$conexion = obtenerConexion();

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Inicializar las variables
$id_candidato = $_GET['id']; // Obtener el id del candidato desde la URL
$candidato = [];

// Verificar si se ha enviado el formulario para modificar los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['txtNombre'];
    $experiencia = $_POST['txtExperiencia'];
    $direccion = $_POST['txtDireccion'];
    $contacto = $_POST['txtContacto'];

    // Consulta SQL para actualizar los datos del candidato
    $sql = "UPDATE Candidatos SET nombre = ?, experiencia = ?, direccion = ?, contacto = ? WHERE id_candidato = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sisss", $nombre, $experiencia, $direccion, $contacto, $id_candidato);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $mensaje = "Los datos del candidato fueron actualizados con éxito.";
    } else {
        $mensaje = "No se realizaron cambios en los datos del candidato.";
    }
    $stmt->close();
}

// Obtener los datos del candidato para mostrar en el formulario de edición
$sql = "SELECT id_candidato, nombre, experiencia, direccion, contacto FROM Candidatos WHERE id_candidato = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_candidato);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $candidato = $resultado->fetch_assoc();
} else {
    die("Candidato no encontrado.");
}

$stmt->close();

// Incluir la cabecera HTML
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="modificar_candidato.php?id=<?php echo $candidato['id_candidato']; ?>" method="post">
            <fieldset>
                <legend>Modificar Candidato</legend>

                <!-- Campo Nombre -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtNombre">Nombre</label>
                    <div class="col-xs-4">
                        <input id="txtNombre" name="txtNombre" class="form-control input-md" type="text" value="<?php echo $candidato['nombre']; ?>" required>
                    </div>
                </div>

                <!-- Campo Experiencia -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtExperiencia">Experiencia</label>
                    <div class="col-xs-4">
                        <input id="txtExperiencia" name="txtExperiencia" class="form-control input-md" type="number" value="<?php echo $candidato['experiencia']; ?>" required>
                    </div>
                </div>

                <!-- Campo Dirección -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtDireccion">Dirección</label>
                    <div class="col-xs-4">
                        <input id="txtDireccion" name="txtDireccion" class="form-control input-md" type="text" value="<?php echo $candidato['direccion']; ?>" required>
                    </div>
                </div>

                <!-- Campo Contacto -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtContacto">Contacto</label>
                    <div class="col-xs-4">
                        <input id="txtContacto" name="txtContacto" class="form-control input-md" type="text" value="<?php echo $candidato['contacto']; ?>" required>
                    </div>
                </div>

                <!-- Botón para guardar cambios -->
                <div class="form-group">
                    <div class="col-xs-4">
                        <input type="submit" class="btn btn-success" value="Guardar Cambios">
                    </div>
                </div>

            </fieldset>
        </form>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info">
                <p><?php echo $mensaje; ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

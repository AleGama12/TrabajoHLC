<?php
// Incluir la función de conexión a la base de datos
require_once("funcionesBD.php");

// Obtener la conexión
$conexion = obtenerConexion();

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Definir las variables para la eliminación
$id_candidato = null;
$mensaje = "";

// Verificar si se ha enviado el formulario con el ID del candidato
if (isset($_POST['txtId'])) {
    // Obtener el ID del candidato desde el formulario
    $id_candidato = $_POST['txtId'];

    // Consulta SQL para eliminar el candidato
    $sql = "DELETE FROM Candidatos WHERE id_candidato = ?";
    
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular el parámetro como entero
        $stmt->bind_param("i", $id_candidato);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = "Candidato con ID $id_candidato ha sido eliminado exitosamente.";
        } else {
            $mensaje = "Error al eliminar el candidato: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $mensaje = "Error al preparar la consulta: " . $conexion->error;
    }
}

// Incluir la cabecera HTML
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <!-- Formulario Borrar Candidato -->
        <form class="form-horizontal" action="borrar_candidato.php" name="frmBorrarCandidato" id="frmBorrarCandidato" method="post">
            <fieldset>
                <h2>Borrar Candidato</h2>

                <!-- Campo ID del Candidato -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtId">Id del Candidato a Borrar:</label>
                    <div class="col-xs-4">
                        <input type="text" id="txtId" name="txtId" class="form-control input-md" required>
                    </div>
                </div>

                <!-- Botón Borrar -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnBorrarCandidato"></label>
                    <div class="col-xs-4">
                        <input type="submit" class="btn btn-danger" value="Borrar" />
                    </div>
                </div>

                <!-- Mensaje de resultado -->
                <?php if ($mensaje): ?>
                    <div class="alert <?php echo ($mensaje == "Candidato con ID $id_candidato ha sido eliminado exitosamente.") ? 'alert-success' : 'alert-danger'; ?>">
                        <p><?php echo $mensaje; ?></p>
                    </div>
                <?php endif; ?>
            </fieldset>
        </form>
    </div>
</div>

</body>
</html>

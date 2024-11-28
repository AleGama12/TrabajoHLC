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
$id_empresa = null;
$mensaje = "";

// Verificar si se ha enviado el formulario con el ID de la empresa
if (isset($_POST['txtId'])) {
    // Obtener el ID de la empresa desde el formulario
    $id_empresa = $_POST['txtId'];

    // Consulta SQL para eliminar la empresa
    $sql = "DELETE FROM Empresas WHERE id_empresa = ?";
    
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular el parámetro como entero
        $stmt->bind_param("i", $id_empresa);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = "Empresa con ID $id_empresa ha sido eliminada exitosamente.";
        } else {
            $mensaje = "Error al eliminar la empresa: " . $stmt->error;
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
        <!-- Formulario Borrar Empresa -->
        <form class="form-horizontal" action="borrar_empresa.php" name="frmBorrarEmpresa" id="frmBorrarEmpresa" method="post">
            <fieldset>
                <h2>Borrar Empresa</h2>

                <!-- Campo ID de la Empresa -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtId">Id de la Empresa a Borrar:</label>
                    <div class="col-xs-4">
                        <input type="text" id="txtId" name="txtId" class="form-control input-md" required>
                    </div>
                </div>

                <!-- Botón Borrar -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnBorrarEmpresa"></label>
                    <div class="col-xs-4">
                        <input type="submit" class="btn btn-danger" value="Borrar" />
                    </div>
                </div>

                <!-- Mensaje de resultado -->
                <?php if ($mensaje): ?>
                    <div class="alert <?php echo ($mensaje == "Empresa con ID $id_empresa ha sido eliminada exitosamente.") ? 'alert-success' : 'alert-danger'; ?>">
                        <p><?php echo $mensaje; ?></p>
                    </div>
                <?php endif; ?>
            </fieldset>
        </form>
    </div>
</div>

</body>
</html>

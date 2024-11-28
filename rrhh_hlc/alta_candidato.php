<?php
// Incluir la función de conexión a la base de datos
require_once("funcionesBD.php");

// Obtener la conexión
$conexion = obtenerConexion();

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verificar si se ha enviado el formulario
if (isset($_POST['btnAceptarAltaCandidato'])) {
    // Obtener los valores del formulario
    $nombre = $_POST['txtNombre'];
    $experiencia = $_POST['txtExperiencia'];
    $direccion = $_POST['txtDireccion'];
    $contacto = $_POST['txtContacto'];

    // Preparar la consulta de inserción
    $sql = "INSERT INTO Candidatos (nombre, experiencia, direccion, contacto) VALUES (?, ?, ?, ?)";

    // Preparar la declaración
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("ssss", $nombre, $experiencia, $direccion, $contacto);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Candidato registrado exitosamente.";
        } else {
            echo "Error al registrar el candidato: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

// Obtener las opciones de candidatos (si es necesario para tu formulario)
$sql = "SELECT id_candidato, nombre FROM Candidatos;";
$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error en la consulta SQL: " . $conexion->error);
}

// Inicializar las opciones del select
$options = "";
while ($fila = $resultado->fetch_assoc()) {
    $options .= "<option value='" . $fila["id_candidato"] . "'>" . $fila["nombre"] . "</option>";
}

// Incluir la cabecera HTML
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <!-- Formulario Alta Candidato -->
        <form class="form-horizontal" action="alta_candidato.php" name="frmAltaCandidato" id="frmAltaCandidato" method="post">
            <fieldset>
                <legend>Formulario de Alta Candidato</legend>

                <!-- Campo Nombre -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtNombre">Nombre</label>
                    <div class="col-xs-4">
                        <input id="txtNombre" name="txtNombre" placeholder="Nombre del Candidato" class="form-control input-md" maxlength="25" type="text" required>
                    </div>
                </div>

                <!-- Campo Experiencia -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtExperiencia">Experiencia</label>
                    <div class="col-xs-4">
                        <input id="txtExperiencia" name="txtExperiencia" placeholder="Años de experiencia" class="form-control input-md" type="text" required>
                    </div>
                </div>

                <!-- Campo Dirección -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtDireccion">Dirección</label>
                    <div class="col-xs-4">
                        <input id="txtDireccion" name="txtDireccion" placeholder="Dirección" class="form-control input-md" type="text" required>
                    </div>
                </div>

                <!-- Campo Contacto -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtContacto">Contacto</label>
                    <div class="col-xs-4">
                        <input id="txtContacto" name="txtContacto" placeholder="Correo o Teléfono" class="form-control input-md" type="text" required>
                    </div>
                </div>

                <!-- Botón de Enviar -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnAceptarAltaCandidato"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarAltaCandidato" name="btnAceptarAltaCandidato" class="btn btn-primary" value="Registrar Candidato" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

</body>
</html>

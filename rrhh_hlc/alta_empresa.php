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
if (isset($_POST['btnAceptarAltaEmpresa'])) {
    // Obtener los valores del formulario
    $nombre = $_POST['txtNombre'];
    $sector = $_POST['txtSector'];
    $ubicacion = $_POST['txtUbicacion'];
    $email = $_POST['txtEmail'];
    $telefono = $_POST['txtTelefono'];

    // Preparar la consulta de inserción
    $sql = "INSERT INTO Empresas (nombre, sector, ubicacion, email, telefono) VALUES (?, ?, ?, ?, ?)";

    // Preparar la declaración
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("ssssi", $nombre, $sector, $ubicacion, $email, $telefono);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Empresa registrada exitosamente.";
        } else {
            echo "Error al registrar la empresa: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

// Obtener las opciones de empresas (si es necesario para tu formulario)
$sql = "SELECT id_empresa, nombre FROM Empresas;";
$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error en la consulta SQL: " . $conexion->error);
}

// Inicializar las opciones del select
$options = "";
while ($fila = $resultado->fetch_assoc()) {
    $options .= "<option value='" . $fila["id_empresa"] . "'>" . $fila["nombre"] . "</option>";
}

// Incluir la cabecera HTML
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <!-- Formulario Alta Empresa -->
        <form class="form-horizontal" action="alta_empresa.php" name="frmAltaEmpresa" id="frmAltaEmpresa" method="post">
            <fieldset>
                <legend>Formulario de Alta Empresa</legend>

                <!-- Campo Nombre -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtNombre">Nombre</label>
                    <div class="col-xs-4">
                        <input id="txtNombre" name="txtNombre" placeholder="Nombre de la Empresa" class="form-control input-md" maxlength="100" type="text" required>
                    </div>
                </div>

                <!-- Campo Sector -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtSector">Sector</label>
                    <div class="col-xs-4">
                        <input id="txtSector" name="txtSector" placeholder="Sector de la Empresa" class="form-control input-md" maxlength="100" type="text" required>
                    </div>
                </div>

                <!-- Campo Ubicación -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtUbicacion">Ubicación</label>
                    <div class="col-xs-4">
                        <input id="txtUbicacion" name="txtUbicacion" placeholder="Ubicación" class="form-control input-md" maxlength="100" type="text" required>
                    </div>
                </div>

                <!-- Campo Email -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtEmail">Email</label>
                    <div class="col-xs-4">
                        <input id="txtEmail" name="txtEmail" placeholder="Correo electrónico" class="form-control input-md" type="email" required>
                    </div>
                </div>

                <!-- Campo Teléfono -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtTelefono">Teléfono</label>
                    <div class="col-xs-4">
                        <input id="txtTelefono" name="txtTelefono" placeholder="Teléfono" class="form-control input-md" type="number" required>
                    </div>
                </div>

                <!-- Botón de Enviar -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnAceptarAltaEmpresa"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarAltaEmpresa" name="btnAceptarAltaEmpresa" class="btn btn-primary" value="Registrar Empresa" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

</body>
</html>

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

// Verificar si se ha enviado el formulario con la experiencia mínima
if (isset($_POST['btnListadoCandidatosParam'])) {
    $experiencia_minima = (int)$_POST['txtExperiencia']; // Obtener la experiencia mínima desde el formulario

    // Consulta SQL para obtener candidatos con más experiencia que la introducida
    $sql = "SELECT id_candidato, nombre, experiencia, direccion, contacto FROM Candidatos WHERE experiencia >= ?";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $experiencia_minima); // Vincular el parámetro de experiencia mínima
    $stmt->execute();
    
    // Obtener los resultados
    $resultado = $stmt->get_result();
    
    // Verificar si se encontraron resultados
    if ($resultado->num_rows > 0) {
        // Almacenar los resultados en el array $candidatos
        while ($fila = $resultado->fetch_assoc()) {
            $candidatos[] = $fila;
        }
    } else {
        $mensaje = "No se encontraron candidatos con más experiencia que " . $experiencia_minima . " años.";
    }
    
    // Cerrar la declaración
    $stmt->close();
}

// Incluir la cabecera HTML
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <!-- Formulario para obtener el listado de candidatos por experiencia -->
        <form class="form-horizontal" action="listar_candidatos_por_experiencia.php" name="frmListadoCandidatosParam" id="frmListadoCandidatosParam" method="post">
            <fieldset>
                <legend>Listado de Candidatos por Experiencia</legend>

                <!-- Campo de experiencia mínima -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtExperiencia">Experiencia Mínima</label>
                    <div class="col-xs-4">
                        <input id="txtExperiencia" name="txtExperiencia" placeholder="Años de experiencia mínima" class="form-control input-md" type="number" required>
                    </div>
                </div>

                <!-- Botón para obtener el listado de candidatos -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnListadoCandidatosParam"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnListadoCandidatosParam" name="btnListadoCandidatosParam" class="btn btn-primary" value="Listado de los candidatos">
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- Mostrar la tabla con los candidatos si se encontraron resultados -->
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
                            <td><?php echo $candidato['experiencia']; ?> años</td>
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

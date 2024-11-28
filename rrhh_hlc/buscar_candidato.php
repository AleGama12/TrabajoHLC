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

// Verificar si se ha enviado el formulario con el id del candidato a buscar
if (isset($_POST['btnBuscarCandidato'])) {
    $id_candidato = $_POST['txtId']; // Obtener el id del candidato desde el formulario

    // Consulta SQL para obtener el candidato con el id especificado
    $sql = "SELECT id_candidato, nombre, experiencia, direccion, contacto FROM Candidatos WHERE id_candidato = ?";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_candidato); // Vincular el parámetro de id del candidato
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
        $mensaje = "No se encontró el candidato con el ID " . $id_candidato . ".";
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
        <form id="frmBuscarCandidato" class="form-horizontal" action="buscar_candidato.php" method="post">
            <fieldset>
                <legend>Buscar Candidato</legend>
                <div class="form-group">
                    <label for="txtId" class="col-xs-4 control-label">ID del Candidato:</label>
                    <div class="col-xs-4">
                        <input type="text" id="txtId" name="txtId" class="form-control input-md" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4">
                        <button type="submit" name="btnBuscarCandidato" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- Mostrar los candidatos encontrados -->
        <?php if (!empty($candidatos)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Experiencia</th>
                        <th>Dirección</th>
                        <th>Contacto</th>
                        <th>Acciones</th>
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
                            <td>
                                <!-- Botón para modificar los datos del candidato -->
                                <a href="modificar_candidato.php?id=<?php echo $candidato['id_candidato']; ?>" class="btn btn-warning">Modificar</a>
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

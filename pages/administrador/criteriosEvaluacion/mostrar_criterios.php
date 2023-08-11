<!doctype html>
<html lang="es">
<head>
    <?php require("../../head.php"); ?>
</head>
<body>
   
<?php require("../../head.php"); ?>
</head>
<body>
    <?php require("../../navbar.php");?>

    <div class="container mt-navbar">
        <?php if (empty($criterios)): ?>
            <p>No se han encontrado criterios de evaluación.</p>
        <?php else: ?>
            <h3>Criterios de evaluación registrados</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Criterio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($criterios as $criterio): ?>
                        <tr>
                            <td><?php echo $criterio['criterio']; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" onclick="editarCriterio(<?php echo $criterio['id']; ?>, '<?php echo $criterio['criterio']; ?>')">Editar</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarCriterio(<?php echo $criterio['id']; ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <!-- Botón Volver -->
        <button type="button" class="btn btn-primary" onclick="volver()">Volver</button>
    </div>

    <?php require("../../footer.php"); ?>
    
    <!-- Script para el botón Volver -->
    <script>
        function volver() {
            history.back();
        }
        
        // Función para editar criterio
        function editarCriterio(id, criterio) {
            // Aquí puedes redirigir a la página de edición del criterio pasando el ID y el criterio como parámetros
            // Por ejemplo, si la página de edición se llama "editar_criterio.php":
            window.location.href = "editar_criterio.php?id=" + id + "&criterio=" + encodeURIComponent(criterio);
        }
        
        // Función para eliminar criterio
        function eliminarCriterio(id) {
            // Aquí puedes realizar una solicitud AJAX al servidor para eliminar el criterio
            // y luego actualizar la tabla sin necesidad de recargar la página
            // Por ejemplo, usando jQuery y una solicitud POST:
            $.post("eliminar_criterio.php", { id: id })
                .done(function(data) {
                    // Si la eliminación fue exitosa, puedes recargar la tabla para actualizarla
                    window.location.reload();
                })
                .fail(function(xhr, status, error) {
                    // En caso de que ocurra un error, puedes mostrar un mensaje de error o realizar alguna acción específica
                    console.error("Error al eliminar el criterio: " + error);
                });
        }
    </script>
</body>
</html>

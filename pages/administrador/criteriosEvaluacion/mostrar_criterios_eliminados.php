<!doctype html>
<html lang="es">
<head>
    <?php require("../../../head.php"); ?>
</head>
<body>
    <?php require("../../../navbar.php");?>

    <div class="container mt-navbar">
        <?php
        $stmt = $db->prepare("SELECT * FROM criterios_evaluacion WHERE eliminado = 1");
        $stmt->execute();
        $criteriosEliminados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($criteriosEliminados)): ?>
            <p>No se han encontrado criterios eliminados.</p>
        <?php else: ?>
            <h3>Criterios de evaluación eliminados</h3>
            <!-- Mostrar criterios eliminados -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">Criterio</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($criteriosEliminados as $criterio): ?>
            <tr>
                <td><?php echo $criterio['criterio']; ?></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" onclick="restaurarCriterio(<?php echo $criterio['id']; ?>)">Restaurar</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $criterio['id']; ?>)">Eliminar definitivamente</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <?php endif; ?>
        
        <!-- Botón Volver -->
        <button type="button" class="btn btn-primary" onclick="volver()">Volver</button>
    </div>

    <?php require("../../../footer.php"); ?>
    
    <script>
        function volver() {
            history.back();
        }
        
        function restaurarCriterio(id) {
            $.post("restaurar_criterio.php", { id: id }, function(data) {
                // Recargar la página para actualizar la lista de criterios eliminados
                window.location.reload();
            });
        }
    </script>
    <script>
    function confirmarEliminar(id) {
        if (confirm("¿Estás seguro de que deseas eliminar definitivamente este criterio?")) {
            eliminarDefinitivamenteCriterio(id);
        }
    }

    function eliminarDefinitivamenteCriterio(id) {
        $.post("eliminar_definitivamente_criterio.php", { id: id })
            .done(function(data) {
                // Si la eliminación definitiva fue exitosa, puedes recargar la página para actualizarla
                window.location.reload();
            })
            .fail(function(xhr, status, error) {
                // En caso de que ocurra un error, puedes mostrar un mensaje de error o realizar alguna acción específica
                console.error("Error al eliminar definitivamente el criterio: " + error);
            });
    }
</script>

</body>
</html>

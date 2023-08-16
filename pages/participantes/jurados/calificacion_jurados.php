<!DOCTYPE html>
<html lang="es">
<?php require("../../../head.php"); ?>

<body>
    <?php require("../../../navbar.php"); ?>

    <div class="container mt-navbar">
        <h3>Cuadro de Calificación de Bandas Marciales</h3>

        <form action="procesar_calificacion.php" method="POST">
            <table>
                <tr>
                    <td><label for="nombre_banda">Nombre de la Banda:</label></td>
                    <td><input type="text"  class="form-control" name="nombre_banda" required></td>
                </tr>
                <tr>
                    <td><label for="nombre_jurado">Nombre del Jurado:</label></td>
                    <td><input type="text"  class="form-control" name="nombre_jurado" required></td>
                </tr>
                <tr>
                    <td><label for="vestuario">Vestuario (0-10):</label></td>
                    <td><input type="number"  class="form-control" name="vestuario" min="0" max="10" step="0.1" required></td>
                </tr>
                <tr>
                    <td><label for="musica">Música (0-10):</label></td>
                    <td><input type="number" class="form-control"  name="musica" min="0" max="10" step="0.1" required></td>
                </tr>
                <tr>
                    <td><label for="alineacion">Alineación (0-10):</label></td>
                    <td><input type="number" class="form-control"  name="alineacion" min="0" max="10" step="0.1" required></td>
                </tr>
                <tr>
                    <td><label for="fecha">Fecha:</label></td>
                    <td><input type="date"  class="form-control" name="fecha" required></td>
                </tr>
                <tr>
                    <td><label for="observaciones">Observaciones:</label></td>
                    <td><textarea  class="form-control" name="observaciones" rows="4" cols="50"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" class="btn-bandrank">Registrar Calificación</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>



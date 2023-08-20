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
                    <td><input type="" class="form-control" name="nombre_banda" required></td>
                </tr>
                <tr>
                    <td><label for="nombre_jurado">Lugar de Procendecia:</label></td>
                    <td><input type="" class="form-control" name="nombre_jurado" required></td>
                </tr>
                <tr>
                    <td><label for="nombre_jurado">Jurado:</label></td>
                    <td><input type="" class="form-control" name="nombre_jurado" required></td>
                </tr>
                <!-- Aquí se inserta la tabla con los aspectos a evaluar -->
                <tr>
                    <td colspan="2">
                        <table class="table table-striped-columns">


                        <?php
            // Datos de ejemplo de categorías
            $calificacion_jurados = $db->prepare("select * from datosbanda where nombre_banda and lugar_procedencia");
            $calificacion_jurados->execute();
            $fetch_calificacion_jurados = $calificacion_jurados->fetchAll(PDO::FETCH_OBJ);


            // Generar filas de la tabla con los datos de las categorías
            foreach ($fetch_calificacion_jurados as $categoria) {?>

            <?php
            }
            ?>


                            <tr>
                                <th>Aspectos a Evaluar</th>
                                <th>Rango</th>
                                <th>Valoración (0-10)</th>
                            </tr>
                            <tr>
                                <td>Puntualidad y orden</td>
                                <td>0-10</td>
                                <td><input type="number" min="0" max="10" step="0.1"></td>
                            </tr>
                            <tr>
                                <td>Uniformidad, presentación</td>
                                <td>0-10</td>
                                <td><input type="number" min="0" max="10" step="0.1"></td>
                            </tr>
                            <tr>
                                <td>Estado, limpieza</td>
                                <td>0-10</td>
                                <td><input type="number" min="0" max="10" step="0.1"></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th>&nbsp;</th>
                                <th><input type="text" id="total_aspectos" class="form-control" readonly></th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Fin de la inserción de la tabla -->
                <script>
        const valoracionInputs = document.querySelectorAll('input[type="number"]');
        const totalAspectosInput = document.getElementById('total_aspectos');

        valoracionInputs.forEach(input => {
            input.addEventListener('input', () => {
                let totalAspectos = 0;
                valoracionInputs.forEach(input => {
                    const valoracion = parseFloat(input.value) || 0;
                    totalAspectos += valoracion;
                });
                totalAspectosInput.value = totalAspectos.toFixed(2);
            });
        });
    </script>
            <tr>
                    <td><label for="observaciones">Observaciones:</label></td>
                    <td><textarea class="form-control" name="observaciones" rows="4" cols="15"></textarea></td>
                </tr>
            <tr>
                    <td colspan="2"><button type="submit" class="btn-bandrank">Guardar Calificación</button></td>
                </tr>
        </form>
    </div>
</body>

</html>

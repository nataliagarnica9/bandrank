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
                    <td><label for="nombre">Nombre de la Banda:</label></td>
                    <td><select class="form-control form-control-lg" name="nombre" id="nombre">
                    <option value="">Selecciona una opción</option>
                    <?php 
                    $query = $db->query("SELECT * FROM banda");
                    $fetch_banda = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach($fetch_banda as $banda) { ?>
                        <option value="<?= $banda->nombre ?>"><?= $banda->nombre?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
                </tr>
                <tr>
                    <td><label for="nombre_ubicacion">Lugar de Procendecia:</label></td>
                    <td><select class="form-control form-control-lg" name="ubicacion" id="ubicacion">
                    <option value="">Selecciona una opción</option>
                    <?php 
                    $query = $db->query("SELECT * FROM banda");
                    $fetch_banda = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach($fetch_banda as $banda) { ?>
                        <option value="<?= $banda->ubicacion ?>"><?= $banda->ubicacion?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
                </tr>
                <tr>
                    <td><label for="nombres">Jurado:</label></td>
                    <td><select class="form-control form-control-lg" name="nombres" id="nombres">
                    <option value="">Selecciona una opción</option>
                    <?php 
                    $query = $db->query("SELECT * FROM jurado");
                    $fetch_jurado = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach($fetch_jurado as $jurado) { ?>
                        <option value="<?= $jurado->nombres ?>"><?= $jurado->nombres?></option>
                    <?php
                    }
                    ?>
                </select></td>
                </tr>
                <!-- Aquí se inserta la tabla con los aspectos a evaluar -->
                <tr>
                    <td colspan="2">
                        <table class="table table-striped-columns">
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

<?php
include_once('../../config.php');
if($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == '') {
    header("Location: ".base_url."inicio.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<?php require("../../head.php"); ?>

<body>
    <?php require("../../navbar.php"); ?>

    <div class="container mt-navbar">
        <h3>Cuadro de calificación de bandas marciales</h3>

        <form id="formulario-calificacion" name="formulario-calificacion" method="POST">
            <input type="hidden" name="id_concurso" value="<?= $_REQUEST["concurso"] ?>">
            <input type="hidden" name="id_categoria" value="<?= $_REQUEST["categoria"] ?>">
            <input type="hidden" name="id_banda" value="<?= $_REQUEST["banda"] ?>">
            <input type="hidden" name="cuantos_detalle" value="1" id="cuantos_detalle">
            <input type="hidden" name="id_planilla" value="<?= $_REQUEST["planilla"] ?>">
            <table class="table table-secondary">
                <tr>
                    <td style="width: 14vw;border-bottom: 0px;"><label for="nombre">Nombre de la Banda:</label></td>
                    <td>
                        <?php
                        $consulta1 = $db->prepare("SELECT * FROM banda where id_banda = ?");
                        $consulta1->bindValue(1, $_REQUEST["banda"]);
                        $consulta1->execute();
                        $fetch_consulta1 = $consulta1->fetch(PDO::FETCH_OBJ);
                        echo $fetch_consulta1->nombre;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 14vw;border-bottom: 0px;"><label for="nombre_ubicacion">Lugar de
                            Procendecia:</label></td>
                    <td>
                        <?php
                        $consulta2 = $db->prepare("SELECT * FROM banda where id_banda = ?");
                        $consulta2->bindValue(1, $_REQUEST["banda"]);
                        $consulta2->execute();
                        $fetch_consulta2 = $consulta2->fetch(PDO::FETCH_OBJ);
                        echo $fetch_consulta2->ubicacion;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 14vw;border-bottom: 0px;"><label for="nombres">Jurado:</label></td>
                    <td>
                        <?php
                        $consulta3 = $db->prepare("SELECT * FROM jurado where id_jurado = ?");
                        $consulta3->bindValue(1, $_SESSION["ID_USUARIO"]);
                        $consulta3->execute();
                        $fetch_consulta3 = $consulta3->fetch(PDO::FETCH_OBJ);
                        echo $fetch_consulta3->nombres . " " . $fetch_consulta3->apellidos;
                        ?>
                    </td>
                </tr>
            </table>
            <!-- Aquí se inserta la tabla con los aspectos a evaluar -->
            <table class="table">
                <tr>
                    <th>Aspectos a Evaluar</th>
                    <th>Rango</th>
                    <th>Valoración</th>
                </tr>
                <?php
                $consulta1_1 = $db->prepare("SELECT * FROM criterio where id_planilla = ? and eliminado = 0");
                $consulta1_1->bindValue(1, $_REQUEST["planilla"]);
                $consulta1_1->execute();
                $fetch_consulta1_1 = $consulta1_1->fetchAll(PDO::FETCH_OBJ);
                ?>
                <input type="hidden" name="numerodecriterios" value="<?= count($fetch_consulta1_1) ?>">
                <?php
                foreach ($fetch_consulta1_1 as $i => $planilla) { ?>
                    <tr>
                        <td><?= $planilla->nombre_criterio ?></td>
                        <td>0-<?= $planilla->rango_calificacion ?></td>
                        <td><input type="number" min="0" max="<?= $planilla->rango_calificacion ?>" step="0.1" class="form-control" name="puntaje-<?= $i ?>">
                            <input type="hidden" name="id_criterioevaluacion-<?= $i ?>" value="<?= $planilla->id_criterio ?>">
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <table class="table" id="penalizaciones-container">
                <tr>
                    <th colspan="2"><label for="penalizacion">Penalizaciones:</label></th>
                    <th><button type="button" class=" btn-bandrank btn-add-penalizacion" style="padding: 6px 9px; font-size: 14px;" onclick="agregarCampoPenalizacion()">Agregar
                            penalización</button></th>
                </tr>

                <tr>
                    <!-- Contenedor para las penalizaciones -->
                    <td colspan="2">
                        <select name="penalizacion-1" class="form-control penalizacion-resta" id="penalizacion-1" onchange="asignarPenalizacion($(this).val(),1)">
                            <option value="">Selecciona una penalización</option>
                            <?php
                            // Consulta para obtener las penalizaciones
                            $consulta_penalizaciones = $db->prepare("SELECT * FROM penalizacion WHERE eliminado = 0");
                            $consulta_penalizaciones->execute();
                            $penalizaciones = $consulta_penalizaciones->fetchAll(PDO::FETCH_OBJ);

                            foreach ($penalizaciones as $i => $penalizacion) {
                                $nombre_penalizacion = $penalizacion->descripcion_penalizacion;

                                // Verifica si el tipo de penalización es "Descalificación"
                                if ($penalizacion->tipo_penalizacion === 'Descalificación') {
                                    $nombre_penalizacion = $penalizacion->descripcion_penalizacion . ' (Descalificación)';
                                }

                                // Muestra el nombre de la penalización y su valor en la opción

                                echo '<option value="' . $penalizacion->id_penalizacion . '" (' . $penalizacion->puntaje_penalizacion . ')">' . $nombre_penalizacion . ' (-' . $penalizacion->puntaje_penalizacion . ' puntos)</option>';
                            }

                            ?>

                        </select>
                    </td>
                    <td><input type="text" disabled id="penalizacion_puntaje-1" class="form-control" value=""></td>
                </tr>

            </table>
            <table class="table">
                <tr>
                    <th>Total</th>
                    <th>&nbsp;</th>
                    <th><input name="total_calificacion" type="text" id="total_aspectos" class="form-control" readonly>
                    </th>
                </tr>
                <tr>
                    <td><label for="observaciones">Observaciones:</label></td>
                    <td colspan="2"><textarea class="form-control" name="observaciones" rows="4" cols="15"></textarea></td>
                </tr>
            </table>
            <table class="table">
                <tr>
                    <th>Firma del instructor</th>
                </tr>
                <tr>
                    <td>
                        <div id="sig">

                        </div>
                        <textarea name="signed" id="signature64" style="display: none;"></textarea>
                        <br>
                        <button class="btn btn-light" id="clear">Limpiar</button>
                    </td>
                </tr>
            </table>
            <button type="button" onclick="guardarCalificacion() " class="btn-bandrank my-5">Guardar calificación</button>
            <td><a href="eleccionplanilla.php?concurso=<?= $_REQUEST['concurso'] ?>&categoria=<?= $_REQUEST["categoria"] ?>&banda=<?= $banda->id_banda ?>" class="btn btn-light">Volver</a></td>
        </form>
    </div>
    <?php require("../../footer.php"); ?>
    <script>
        var nextinput = 1;
        const penalizacionesContainer = document.getElementById('penalizaciones-container');
        const btnAddPenalizacion = document.querySelector('.btn-add-penalizacion');

        $(document).ready(function(){
            var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
            })

            $('#clear').click(function(e) {
                e.preventDefault();
                sig.signature('clear');
                $("#signature64").val('');
            })
        });

        penalizacionesContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-remove-penalizacion')) {
                eliminarCampoPenalizacion(event);
            }
        });

        // Escuchar eventos de cambio en los inputs y selects relevantes
        let valoracionInputs1 = document.querySelectorAll('input[type="number"]');
        valoracionInputs1.forEach(input => {
            input.addEventListener('blur', calcularTotal);
        });

        const penalizacionSelects = document.querySelectorAll('select[class="penalizacion-resta"]');
        penalizacionSelects.forEach(select => {
            select.addEventListener('change', calcularTotal);
        });


        // Función para agregar un campo de penalización
        function agregarCampoPenalizacion() {
            nextinput++;
            $('#cuantos_detalle').val(nextinput);
            const nuevoCampoPenalizacion = document.createElement('tr');
            nuevoCampoPenalizacion.innerHTML = `
                <td colspan="2">
                    <select name="penalizacion-${nextinput}" id="penalizacion-${nextinput}" class="form-control penalizacion-resta" onchange="asignarPenalizacion($(this).val(),${nextinput})">
                    <option value="">Selecciona una penalización</option>
                    <?php
                    // Consulta para obtener las penalizaciones
                    $consulta_penalizaciones = $db->prepare("SELECT * FROM penalizacion WHERE eliminado = 0");
                    $consulta_penalizaciones->execute();
                    $penalizaciones = $consulta_penalizaciones->fetchAll(PDO::FETCH_OBJ);

                    foreach ($penalizaciones as $penalizacion) {
                        $nombre_penalizacion = $penalizacion->descripcion_penalizacion;

                        // Verifica si el tipo de penalización es "Descalificación"
                        if ($penalizacion->tipo_penalizacion === 'Descalificación') {
                            $nombre_penalizacion = $penalizacion->descripcion_penalizacion . ' (Descalificación)';
                        }

                        // Muestra el nombre de la penalización y su valor en la opción
                        echo '<option value="' . $penalizacion->id_penalizacion . '">' . $nombre_penalizacion . ' (-' . $penalizacion->puntaje_penalizacion . ' puntos)</option>';
                    }
                    ?>
                </select>
                </td>
                <td>
                    <input type="text" disabled id="penalizacion_puntaje-${nextinput}" class="form-control" value="">
                </td>
                <button type="button" class="btn-bandrank btn-remove-penalizacion"style="padding: 6px 9px; font-size: 14px;">Eliminar</button>
            `;
            penalizacionesContainer.appendChild(nuevoCampoPenalizacion);
        }

        // Función para eliminar un campo de penalización
        function eliminarCampoPenalizacion(event) {
            const campoPenalizacion = event.target.parentElement;
            if (penalizacionesContainer.children.length > 1) {
                penalizacionesContainer.removeChild(campoPenalizacion);
                calcularTotal();
            }
        }

        // Función para calcular el total restando las penalizaciones
        // Función para calcular el total restando las penalizaciones
        function calcularTotal(input) {
            let valoracionInputs = document.querySelectorAll('input[type="number"]');
            const totalAspectosInput = document.getElementById('total_aspectos');
            let totalAspectos = 0;

            // Calcular la suma de las valoraciones
            valoracionInputs.forEach(input => {
                const valoracion = parseFloat(input.value) || 0;
                totalAspectos += valoracion;
            });

            for (i = 1; i <= nextinput; i++) {
                let num_penalizacion = $("#penalizacion_puntaje-" + i).val() == '' ? 0 : $("#penalizacion_puntaje-" + i).val();
                totalAspectos -= num_penalizacion;
            }

            // Actualizar el campo del total
            totalAspectosInput.value = totalAspectos.toFixed(2);
        }

        function guardarCalificacion() {
            $.ajax({
                url: 'procesar_calificacion.php',
                dataType: 'json',
                type: 'POST',
                data: $('#formulario-calificacion').serialize(),
                beforeSend: function (){
                        Swal.fire({
                            icon: 'info',
                            title: 'Registrando información',
                            text: 'Por favor espera un momento mientras se registra la calificación',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    }
            }).done(function(response) {
                if (response.status == '200') {
                    Swal.close();
                    Swal.fire({
                            icon: 'success',
                            title: 'Se guardó correctamente la calificación',
                            allowEscapeKey: false,
                            allowOutsideClick: false
                    });
                    setTimeout(function(){
                        location.href = 'inicio.php';
                    },2000);
                } else {
                    Swal.close();
                    Swal.fire({
                            icon: 'error',
                            title: 'Hubo un error al guardar la calificación',
                            text: response.message,
                            allowEscapeKey: false,
                            allowOutsideClick: false
                    });
                    //setTimeout(function(){
                    //    location.reload();
                    //},2000);
                }
            });
        }

        function asignarPenalizacion(penalizacion, input) {
            $.ajax({
                url: '../administrador/penalizacion/penalizacion_controller.php?action=obtener_puntaje_penalizacion',
                data: {
                    id: penalizacion
                },
                dataType: 'json',
                type: 'get',
            }).done(function(response) {
                $('#penalizacion_puntaje-' + input).val(response.id);
                calcularTotal();
            });
        }

        $("input[type='number']").on("input", function() {
            var valorInput = $(this).val();
            var max = parseInt($(this).attr("max"));

            if (valorInput > max) {
                $(this).val(max); // Establecer el valor máximo si es mayor
            }
        });
    </script>

</body>

</html>
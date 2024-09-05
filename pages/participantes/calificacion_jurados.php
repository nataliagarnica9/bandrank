<?php
include_once('../../config.php');
if($_SESSION["ROL"] != 'jurado') {
    header("Location: ".base_url."inicio.php");
}
// Consulta para obtener los datos de la banda
$sel_banda = $db->prepare("SELECT * FROM banda WHERE id_banda = ?");
$sel_banda->execute(array($_POST["banda"]));
$fetch_banda = $sel_banda->fetch(PDO::FETCH_OBJ);

// Consulta para obtener los datos del jurado calificador
$sel_jurado = $db->prepare("SELECT * FROM jurado where id_jurado = ?");
$sel_jurado->bindValue(1, $_SESSION["ID_USUARIO"]);
$sel_jurado->execute();
$fetch_jurado = $sel_jurado->fetch(PDO::FETCH_OBJ);

// Consulta para obtener las penalizaciones
$consulta_penalizaciones = $db->prepare("SELECT * FROM penalizacion WHERE eliminado = 0");
$consulta_penalizaciones->execute();
$penalizaciones = $consulta_penalizaciones->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../../head.php'; ?>
<title>Calificación - BandRank</title>
<style>
    #draw-canvas {
        border: 2px dotted #CCCCCC;
        border-radius: 5px;
        cursor: crosshair;
    }

    #draw-dataUrl {
        width: 100%;
    }
    h3 {
        margin: 10px 15px;
    }

    .button:active {
        transform: scale(0.9);
    }

    .contenedor {
        flex: 1;
        width: 100%;
        margin: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

</style>
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php include '../../navbar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Calificación</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Calificación</a></div>
                        <div class="breadcrumb-item">Calificación</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Cuadro de calificación de bandas marciales</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la calificación para la banda <?= ucfirst(strtolower($fetch_banda->nombre)) ?></h6>
                                </div>
                                <div class="card-body">
                                    <form id="formulario-calificacion" name="formulario-calificacion" method="POST">
                                        <input type="hidden" name="id_concurso" value="<?= $_POST["concurso"] ?>">
                                        <input type="hidden" name="id_categoria" value="<?= $_POST["categoria"] ?>">
                                        <input type="hidden" name="id_banda" value="<?= $_POST["banda"] ?>">
                                        <input type="hidden" name="cuantos_detalle" value="1" id="cuantos_detalle">
                                        <input type="hidden" name="id_planilla" value="<?= $_POST["planilla"] ?>">
                                        <table class="table table-secondary">
                                            <tr>
                                                <td style="width: 14vw;border-bottom: 0px;"><label for="nombre">Nombre de la Banda:</label></td>
                                                <td>
                                                    <?php
                                                    echo $fetch_banda->nombre;
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 14vw;border-bottom: 0px;"><label for="nombre_ubicacion">Lugar de
                                                        Procedencia:</label></td>
                                                <td>
                                                    <?php
                                                    echo $fetch_banda->ubicacion;
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 14vw;border-bottom: 0px;"><label for="nombres">Jurado:</label></td>
                                                <td>
                                                    <?php
                                                    echo $fetch_jurado->nombres . " " . $fetch_jurado->apellidos;
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
                                            $sel_criterio = $db->prepare("SELECT * FROM criterio where id_planilla = ? and eliminado = 0");
                                            $sel_criterio->bindValue(1, $_POST["planilla"]);
                                            $sel_criterio->execute();
                                            $fetch_criterio = $sel_criterio->fetchAll(PDO::FETCH_OBJ);
                                            ?>
                                            <input type="hidden" name="numerodecriterios" value="<?= count($fetch_criterio) ?>">
                                            <?php
                                            foreach ($fetch_criterio as $i => $planilla) { ?>
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

                                        <!-- Tabla de penalizaciones -->
                                        <table class="table" id="penalizaciones-container">
                                            <tr>
                                                <th colspan="2"><label for="penalizacion">Penalizaciones:</label></th>
                                                <th><button type="button" class="btn btn-primary btn-add-penalizacion" style="padding: 6px 9px; font-size: 14px;" onclick="agregarCampoPenalizacion()">Agregar
                                                        penalización</button></th>
                                            </tr>

                                            <tr>
                                                <!-- Contenedor para las penalizaciones -->
                                                <td colspan="2">
                                                    <select name="penalizacion-1" class="form-control penalizacion-resta" id="penalizacion-1" onchange="asignarPenalizacion($(this).val(),1)">
                                                        <option value="">Selecciona una penalización</option>
                                                        <?php
                                                        foreach ($penalizaciones as $i => $penalizacion) {
                                                            $nombre_penalizacion = $penalizacion->descripcion_penalizacion;

                                                            // Verifica si el tipo de penalización es "Descalificación"
                                                            if ($penalizacion->tipo_penalizacion === 'Descalificación') {
                                                                $nombre_penalizacion = $penalizacion->descripcion_penalizacion . ' (Descalificación)';
                                                            }

                                                            echo '<option value="' . $penalizacion->id_penalizacion . '" (' . $penalizacion->puntaje_penalizacion . ')">' . $nombre_penalizacion . ' (-' . $penalizacion->puntaje_penalizacion . ' puntos)</option>';
                                                        }

                                                        ?>

                                                    </select>
                                                </td>
                                                <td><input type="text" disabled id="penalizacion_puntaje-1" class="form-control penalizaciones" value=""></td>
                                            </tr>

                                        </table>

                                        <!-- Tabla de totales -->
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

                                        <!-- Tabla de firma -->
                                        <table class="table">
                                            <tr>
                                                <th>Firma del instructor</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="contenedor">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <canvas id="draw-canvas" width="620" height="260">
                                                                    No tienes un buen navegador.
                                                                </canvas>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="button" class="btn btn-primary" id="draw-submitBtn" value="Crear Imagen"></input>
                                                                <input type="button" class="btn" id="draw-clearBtn" value="Limpiar"></input>
                                                                <label>Tamaño Puntero</label>
                                                                <input type="range" class="form-range" id="puntero" min="1" default="1" max="5" width="10%">
                                                                <textarea name="signed" id="draw-dataUrl" style="display: none"></textarea>
                                                            </div>
                                                        </div>
                                                        <!--<div class="contenedor">
                                                            <div class="col-md-12">
                                                                <img id="draw-image" src="" alt="Tu Imagen aparecera Aqui!" />
                                                            </div>
                                                        </div>-->
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <button type="button" onclick="guardarCalificacion() " class="btn btn-primary my-5">Guardar calificación</button>
                                        <td><a href="eleccion_planilla.php?concurso=<?= $_POST['concurso'] ?>&categoria=<?= $_POST["categoria"] ?>&banda=<?= $fetch_banda->id_banda ?>" class="btn btn-light">Volver</a></td>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; 2023
                <div class="bullet"></div>
            </div>
            <div class="footer-right">
                <?php echo date('d') . ' de ' . date('M') . ' de ' . date('Y');?>
            </div>
        </footer>
    </div>
</div>
<!-- General JS Scripts -->
<script src="../../dist/js/signature.js"></script>
<?php include '../../footer.php'; ?>

<script>
    var nextinput = 1;
    const penalizacionesContainer = document.getElementById('penalizaciones-container');
    const btnAddPenalizacion = document.querySelector('.btn-add-penalizacion');

    $(document).ready(function(){

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
                    <input type="text" disabled id="penalizacion_puntaje-${nextinput}" class="form-control penalizaciones" value="">
                </td>
                <button type="button" class="btn btn-danger btn-remove-penalizacion"style="padding: 6px 9px; font-size: 14px;"><i class="far fa-trash-alt"></i></button>
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
            let num_penalizacion = $("#penalizacion_puntaje-" + i).val() == '' || $("#penalizacion_puntaje-" + i).val() == undefined ? 0 : $("#penalizacion_puntaje-" + i).val();
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
            url: '../administrador/penalizacion/penalizacionController.php?action=obtener_puntaje_penalizacion',
            data: {
                id: penalizacion
            },
            dataType: 'json',
            type: 'get',
        }).done(function(response) {
            if(response.tipo == 'Descalificación') {
                $('#penalizacion_puntaje-' + input).val(response.id);
                Swal.fire({
                    icon: 'info',
                    title: 'Importante',
                    text: 'Seleccionaste una penalización de tipo penalización, automáticamente se pondrán los aspectos en 0,'+
                        ' si modificas algún valor no se procesará la descalificación. ',
                    confirmButtonText:'Entendido',
                    confirmButtonColor: '#FF751F'
                });

                let valoracionInputs = document.querySelectorAll('input[type="number"]');
                const totalAspectosInput = document.getElementById('total_aspectos');

                // Calcular la suma de las valoraciones
                valoracionInputs.forEach(input => {
                    input.value = 0;
                    totalAspectos = 0;
                });

            } else {
                $('#penalizacion_puntaje-' + input).val(response.id);
            }
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
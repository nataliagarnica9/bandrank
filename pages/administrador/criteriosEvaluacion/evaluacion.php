<!doctype html>
<html lang="es">
    <?php require("../../../head.php"); ?>
<body>
    <?php require("../../../navbar.php");?>

    <div class="container mt-navbar">
        <h2 class="mt-4 mb-4">Registro de evaluación</h2>
        <h4 class="mt-4 mb-4" style="font-size: 14px; color: #888;">En esta página podrás realizar los cambios requeridos a los distintos tipos de criterios evaluativos para las bandas.</h4>

        <form action="evaluacion_controller.php?action=guardar_criterios" method="POST">
            <div id="contenedor-criterios">
                <!-- Campos de criterios se agregarán dinámicamente aquí -->
            </div>

            <button type="button" class="btn btn-primary mb-3" onclick="agregarCriterio()">Agregar criterio</button>
            <button type="button" class="btn btn-danger mb-3" onclick="reducirCriterio()">Reducir Criterios</button>
            <button type="submit" class="btn btn-primary mb-3">Guardar criterios</button>
            

        </form>
        <a href="evaluacion_controller.php?action=mostrar_criterios" class="btn btn-warning mb-3" style="background-color: #ff751f; border-color: #ff751f; color: white;">Mostrar criterios registrados</a>
        <a href="mostrar_criterios_eliminados.php" class="btn btn-secondary mb-3" style="background-color: #ff751f; border-color: #ff751f; color: white;">Mostrar criterios eliminados</a>
    </div>

    <?php require("../../../footer.php"); ?>
    <style>
        /* Estilos personalizados para el contenedor de criterios */
        .input-group {
            border: 1px solid #ccc;
            border-radius: 1px;
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 2px;
            background-color: white;
        }

        /* Estilo adicional para el último contenedor */
        .input-group:last-child {
            margin-bottom: 0;
        }

        /* Estilos para los campos de criterio */
        .form-control.criterio-input {
            background-color: #f5f5f5;
            border: 1px solid white;
            border-radius: 2px;
            padding: 5px 10px;
        }
    </style>
    <script>
    function agregarCriterio() {
            const contenedor = document.getElementById('contenedor-criterios');
            const inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group');

            const criterioInput = document.createElement('input');
            criterioInput.type = 'text';
            criterioInput.classList.add('form-control', 'criterio-input');
            criterioInput.name = 'criterios[]';
            criterioInput.required = true;

            inputGroup.appendChild(criterioInput);
            contenedor.appendChild(inputGroup);
        }
    </script>
    <script>
    function reducirCriterio() {
        const contenedor = document.getElementById('contenedor-criterios');
        const criterios = contenedor.querySelectorAll('.input-group');
        
        if (criterios.length > 0) {
            contenedor.removeChild(criterios[criterios.length - 1]);
        }
    }
</script>

</body>
</html>

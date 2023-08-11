<!doctype html>
<html lang="es">
<head>
    <?php require("../../head.php"); ?>
</head>
<body>
    <?php require("../../navbar.php");?>

    <div class="container mt-navbar">
        <h3>Registro de evaluación</h3>

        <form action="evaluacion_controller.php?action=guardar_criterios" method="POST">
            <div id="contenedor-criterios">
                <!-- Campos de criterios se agregarán dinámicamente aquí -->
            </div>

            <button type="button" class="btn btn-primary" onclick="agregarCriterio()">Agregar Criterio</button>
            <button type="submit" class="btn btn-primary">Guardar Criterios</button>
        </form>
        <a href="evaluacion_controller.php?action=mostrar_criterios" class="btn btn-secondary">Mostrar Criterios Registrados</a>
    </div>

    <?php require("../../footer.php"); ?>
    <style>
        /* Estilos personalizados para el contenedor de criterios */
        .input-group {
            border: 1px solid black;
            border-radius: 5px;
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 5px;
        }

        /* Estilo adicional para el último contenedor */
        .input-group:last-child {
            margin-bottom: 10px;
        }
    </style>
    <script>
    function agregarCriterio() {
            const contenedor = document.getElementById('contenedor-criterios');
            const inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group');

            const criterioInput = document.createElement('input');
            criterioInput.type = 'text';
            criterioInput.classList.add('form-control');
            criterioInput.name = 'criterios[]';
            criterioInput.required = true;

            inputGroup.appendChild(criterioInput);
            contenedor.appendChild(inputGroup);
        }
    </script>
</body>
</html>

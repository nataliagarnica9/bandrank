<?php
require_once("../../../config.php"); // Asegúrate de incluir tu archivo de configuración de base de datos aquí

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];

    try {
        $stmt = $db->prepare("UPDATE criterios_evaluacion SET eliminado = 0 WHERE id = ?");
        $stmt->execute([$id]);
        echo "Restauración exitosa";
    } catch (PDOException $e) {
        echo "Error al restaurar el criterio: " . $e->getMessage();
    }
} else {
    echo "Solicitud inválida";
}
?>

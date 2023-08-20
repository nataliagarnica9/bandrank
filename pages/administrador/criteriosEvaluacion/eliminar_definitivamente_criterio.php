<?php
require_once("../../../config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];

    try {
        $stmt = $db->prepare("DELETE FROM criterios_evaluacion WHERE id = ?");
        $stmt->execute([$id]);
        echo "Eliminación definitiva exitosa";
    } catch (PDOException $e) {
        echo "Error al eliminar definitivamente el criterio: " . $e->getMessage();
    }
} else {
    echo "Solicitud inválida";
}
?>

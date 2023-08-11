<?php

class Evaluacion {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function guardarCriterios($criterios) {
        try {
            $stmt = $this->db->prepare("INSERT INTO criterios_evaluacion (criterio) VALUES (?)");

            foreach ($criterios as $criterio) {
                $stmt->execute([$criterio]);
            }

            return true;
        } catch (PDOException $e) {
            // En caso de error, puedes manejarlo o simplemente retornar false
            return false;
        }
    }
    public function obtenerCriterios() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM criterios_evaluacion");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En caso de error, puedes manejarlo o simplemente retornar un array vacío
            return array();
        }

        
    }

    public function eliminarCriterio($id_criterio) {
        try {
            $stmt = $this->db->prepare("DELETE FROM criterios_evaluacion WHERE id = ?");
            $stmt->execute([$id_criterio]);

            return true;
        } catch (PDOException $e) {
            // En caso de error, puedes manejarlo o simplemente retornar false
            return false;
        }}
        public function actualizarCriterio($id, $criterio) {
            try {
                $stmt = $this->db->prepare("UPDATE criterios_evaluacion SET criterio = ? WHERE id = ?");
                $stmt->execute([$criterio, $id]);
    
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    }


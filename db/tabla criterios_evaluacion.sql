CREATE TABLE criterios_evaluacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    criterio VARCHAR(255) NOT NULL
);


ALTER TABLE criterios_evaluacion
    ADD eliminado TINYINT(1) NOT NULL DEFAULT 0;
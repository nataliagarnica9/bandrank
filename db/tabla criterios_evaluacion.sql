CREATE TABLE criterio (
    id_criterio INT AUTO_INCREMENT PRIMARY KEY,
    nombre_criterio VARCHAR(255) NOT NULL,
    rango_calificacion VARCHAR(50) NOT NULL,
    id_planilla INT NOT NULL,
    eliminado TINYINT NOT NULL DEFAULT 0, -- Columna para indicar si el criterio está eliminado (0: No, 1: Sí)
    FOREIGN KEY (id_planilla) REFERENCES planilla(id_planilla)
);

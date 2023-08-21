CREATE TABLE planilla (
    id_planilla INT AUTO_INCREMENT PRIMARY KEY,
    nombre_planilla VARCHAR(255) NOT NULL
);

ALTER TABLE planilla
ADD eliminado TINYINT(1) NOT NULL DEFAULT 0,
ADD id_concurso INT,
ADD FOREIGN KEY (id_concurso) REFERENCES concurso(id_concurso);

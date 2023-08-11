CREATE SCHEMA bandrank;

CREATE TABLE jurado
(
    id                       INT AUTO_INCREMENT,
    documento_identificacion VARCHAR(30)  NOT NULL,
    nombres                  VARCHAR(120) NOT NULL,
    apellidos                VARCHAR(120) NOT NULL,
    celular                  INT          NULL,
    correo                   VARCHAR(150) NOT NULL,
    fecha_registro           DATETIME     NOT NULL,
    CONSTRAINT jurado_pk
        PRIMARY KEY (id)
);

CREATE TABLE `bandrank`.`concurso` (`id_concurso` INT(11) NOT NULL AUTO_INCREMENT , `nombre_concurso` VARCHAR(255) NOT NULL , `ubicacion` VARCHAR(255) NOT NULL , `director` VARCHAR(255) NOT NULL , PRIMARY KEY (`id_concurso`)) ENGINE = InnoDB;
ALTER TABLE `concurso` ADD `eliminado` INT(1) NOT NULL AFTER `director`;

CREATE TABLE `bandrank`.`autenticacion` (`clave_administrador` VARCHAR(50) NULL ) ENGINE = InnoDB;
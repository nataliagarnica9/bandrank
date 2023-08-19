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

ALTER TABLE `jurado` ADD `id_concurso` INT NOT NULL AFTER `fecha_registro`;

ALTER TABLE `concurso` ADD `finalizado` INT NOT NULL DEFAULT '0' COMMENT '0 para concurso activo, 1 para concurso finalizado' AFTER `eliminado`;

CREATE TABLE `bandrank`.`categorias_concurso` (`id_categoria` INT NOT NULL AUTO_INCREMENT , `nombre_categoria` VARCHAR(255) NOT NULL , `eliminado` INT NOT NULL DEFAULT '0' COMMENT '0 para activo, 1 para eliminado' , PRIMARY KEY (`id_categoria`)) ENGINE = InnoDB;

ALTER TABLE `concurso` ADD `id_categoria` INT NOT NULL AFTER `director`, ADD `fecha_evento` DATE NOT NULL AFTER `id_categoria`;

ALTER TABLE `jurado` ADD `firma` VARCHAR(255) NULL COMMENT 'Nombre del archivo imagen de la firma' AFTER `id_concurso`;

ALTER TABLE `jurado` ADD `clave` VARCHAR(255) NOT NULL AFTER `correo`;

ALTER TABLE `jurado` ADD `activo` INT NOT NULL DEFAULT '1' COMMENT '1 para activo 0 para inactivo' AFTER `firma`;

CREATE TABLE planilla (
    id_planilla INT AUTO_INCREMENT PRIMARY KEY,
    nombre_planilla VARCHAR(255) NOT NULL
);

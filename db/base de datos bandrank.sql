CREATE SCHEMA bandrank;

/*  --------------------------------- Tabla jurado ------------------------------------------------------- */

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

ALTER TABLE `jurado` ADD `id_concurso` INT NOT NULL AFTER `fecha_registro`;

ALTER TABLE `jurado` ADD `firma` VARCHAR(255) NULL COMMENT 'Nombre del archivo imagen de la firma' AFTER `id_concurso`;

ALTER TABLE `jurado` ADD `clave` VARCHAR(255) NOT NULL AFTER `correo`;

ALTER TABLE `jurado` ADD `activo` INT NOT NULL DEFAULT '1' COMMENT '1 para activo 0 para inactivo' AFTER `firma`;

/*---------------------------------- Tabla concurso ------------------------------------------------------ */

CREATE TABLE `concurso` (`id_concurso` INT(11) NOT NULL AUTO_INCREMENT , `nombre_concurso` VARCHAR(255) NOT NULL , `ubicacion` VARCHAR(255) NOT NULL , `director` VARCHAR(255) NOT NULL , PRIMARY KEY (`id_concurso`)) ENGINE = InnoDB;

ALTER TABLE `concurso` ADD `eliminado` INT(1) NOT NULL AFTER `director`;

ALTER TABLE `concurso` ADD `finalizado` INT NOT NULL DEFAULT '0' COMMENT '0 para concurso activo, 1 para concurso finalizado' AFTER `eliminado`;

ALTER TABLE `concurso` ADD `id_categoria` INT NOT NULL AFTER `director`, ADD `fecha_evento` DATE NOT NULL AFTER `id_categoria`;

/*---------------------------------- Tabla categorias concurso ------------------------------------------------------ */

CREATE TABLE `categorias_concurso` (`id_categoria` INT NOT NULL AUTO_INCREMENT , `nombre_categoria` VARCHAR(255) NOT NULL , `eliminado` INT NOT NULL DEFAULT '0' COMMENT '0 para activo, 1 para eliminado' , PRIMARY KEY (`id_categoria`)) ENGINE = InnoDB;

/*---------------------------------- Tabla de autenticación ------------------------------------------------------ */

CREATE TABLE `autenticacion` (`clave_administrador` VARCHAR(50) NULL ) ENGINE = InnoDB;

/*---------------------------------- Tabla banda ----------------------------------------------------------------- */

CREATE TABLE `banda` (
    `id_banda` INT(11) NOT NULL AUTO_INCREMENT ,
    `nombre` VARCHAR(50) NOT NULL ,
    `ubicacion` VARCHAR(50) NOT NULL ,
    `nombre_instructor` VARCHAR(50) NOT NULL ,
    `correo_instructor` VARCHAR(50) NOT NULL ,
    PRIMARY KEY (`id_banda`)
) ENGINE = InnoDB;

ALTER TABLE `banda` ADD `id_categoria` INT(10) NOT NULL;

ALTER TABLE `banda` ADD `id_concurso` INT NOT NULL AFTER `id_categoria`;

/*---------------------------------- Tabla planilla -------------------------------------------------------------- */

CREATE TABLE planilla (
    id_planilla INT AUTO_INCREMENT PRIMARY KEY,
    nombre_planilla VARCHAR(255) NOT NULL
);

ALTER TABLE planilla
ADD eliminado TINYINT(1) NOT NULL DEFAULT 0,
ADD id_concurso INT,
ADD FOREIGN KEY (id_concurso) REFERENCES concurso(id_concurso);

/*---------------------------------- Tabla criterios de evaluación -------------------------------------------------------------- */

CREATE TABLE criterio (
    id_criterio INT AUTO_INCREMENT PRIMARY KEY,
    nombre_criterio VARCHAR(255) NOT NULL,
    rango_calificacion VARCHAR(50) NOT NULL,
    id_planilla INT NOT NULL,
    eliminado TINYINT NOT NULL DEFAULT 0, -- Columna para indicar si el criterio está eliminado (0: No, 1: Sí)
    FOREIGN KEY (id_planilla) REFERENCES planilla(id_planilla)
);

/*---------------------------------- Tabla login-------------------------------------------------------------- */

create table login
(
    id_login     int auto_increment,
    correo       varchar(200) not null,
    clave        varchar(200) null,
    tipo_usuario varchar(10)  not null comment 'Define si es jurado o instructor',
    id_registro  int          not null comment 'Almacena el id en la tabla de jurado o de banda',
    constraint login_pk
        primary key (id_login)
);
/*---------------------------------- Tabla penalizacion -------------------------------------------------------------- */

CREATE TABLE penalizacion (
    id_penalizacion INT PRIMARY KEY AUTO_INCREMENT,
    descripcion_penalizacion VARCHAR(255) NOT NULL,
    tipo_penalizacion ENUM('Resta', 'Descalificación') NOT NULL,
    puntaje_penalizacion INT DEFAULT 0,
    eliminado TINYINT NOT NULL DEFAULT 0
);

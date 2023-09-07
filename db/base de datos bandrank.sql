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

alter table banda
    modify nombre varchar(255) not null;

alter table banda
    modify ubicacion varchar(255) not null;

alter table banda
    modify nombre_instructor varchar(255) not null;

alter table banda
    modify correo_instructor varchar(255) not null;

alter table banda
    add clave varchar(255) null after correo_instructor;

ALTER TABLE `banda` ADD `firma` VARCHAR(255) NOT NULL AFTER `clave`;

ALTER TABLE `banda` DROP `categoria`;

ALTER TABLE banda
    add descalificado TINYINT(1) NOT NULL DEFAULT 0;

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

/*---------------------------------- Tabla encabezado_calificacion -------------------------------------------------------------- */

CREATE TABLE `encabezado_calificacion` (
  `id_calificacion` int(10) NOT NULL,
  `id_jurado` int(10) NOT NULL,
  `id_concurso` int(10) NOT NULL,
  `id_planilla` int(10) NOT NULL,
  `total_calificacion` int(10) NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `id_banda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

alter table encabezado_calificacion
    add constraint encabezado_calificacion_pk
        primary key (id_calificacion);

alter table encabezado_calificacion
    modify id_calificacion int(10) auto_increment;

alter table encabezado_calificacion
    auto_increment = 1;

alter table encabezado_calificacion
    modify total_calificacion double(20,1);


/*---------------------------------- Tabla detalle_calificacion-------------------------------------------------------------- */
CREATE TABLE `detalle_calificacion` (
  `id_detallecalificacion` int(10) NOT NULL,
  `id_calificacion` int(10) NOT NULL,
  `id_criterioevaluacion` int(10) NOT NULL,
  `puntaje` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

alter table detalle_calificacion
    add constraint detalle_calificacion_pk
        primary key (id_detallecalificacion);

alter table detalle_calificacion
    modify id_detallecalificacion int(10) auto_increment;

alter table detalle_calificacion
    auto_increment = 1;

/*----------------------------*/

alter table jurado
    change id id_jurado int auto_increment;


/*---------------------------------- Tabla penalizacion-------------------------------------------------------------- */


CREATE TABLE `bandrank`.`penalizacionxcalificacion` (`id_penalizacionxcalificacion` INT(10) NOT NULL AUTO_INCREMENT , `id_penalizacion` INT(10) NOT NULL , `id_calificacion` INT(10) NOT NULL , PRIMARY KEY (`id_penalizacionxcalificacion`)) ENGINE = InnoDB;

create table detalle_penalizacion
(
    id_detalle_penalizacion int null,
    id_calificacion         int null,
    id_penalizacion         int null,
    constraint detalle_penalizacion_pk
        primary key (id_detalle_penalizacion),
    constraint detalle_penalizacion_encabezado_calificacion_id_calificacion_fk
        foreign key (id_calificacion) references encabezado_calificacion (id_calificacion),
    constraint detalle_penalizacion_penalizacion_id_penalizacion_fk
        foreign key (id_penalizacion) references penalizacion (id_penalizacion)
);

alter table detalle_penalizacion
    modify id_detalle_penalizacion int auto_increment;

alter table detalle_penalizacion
    auto_increment = 1;


create table planillaxjurado
(
    id_planillaxjurado int auto_increment,
    id_jurado          int null,
    id_planilla        int null,
    constraint planillaxjurado_pk
        primary key (id_planillaxjurado),
    constraint planillaxjurado_jurado_id_jurado_fk
        foreign key (id_jurado) references jurado (id_jurado),
    constraint planillaxjurado_planilla_id_planilla_fk
        foreign key (id_planilla) references planilla (id_planilla)
);

alter table encabezado_calificacion
    add firma_instructor text null;
    
    CREATE TABLE categoriasxconcurso (`id_calificacionxconcurso` INT(11) NOT NULL AUTO_INCREMENT , `id_concurso` INT(11) NOT NULL , `id_categoria` INT(11) NOT NULL , PRIMARY KEY (`id_calificacionxconcurso`)) ENGINE = InnoDB;
    
    ALTER TABLE `concurso` DROP `id_categoria`;

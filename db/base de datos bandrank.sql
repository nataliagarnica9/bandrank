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
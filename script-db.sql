CREATE DATABASE appsalon_db;
USE appsalon_db;

CREATE TABLE `appsalon_db`.`usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(60) NULL,
  `apellido` VARCHAR(60) NULL,
  `email` VARCHAR(30) NULL,
  `telefono` VARCHAR(10) NULL,
  `admin` TINYINT(1) NULL,
  `confirmado` TINYINT(1) NULL,
  `token` VARCHAR(15) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE `appsalon_db`.`servicios` (
  `id` INT(11) NOT NULL,
  `nombre` VARCHAR(60) NULL,
  `precio` DECIMAL(5,2) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Corte de Cabello Mujer', '90.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Corte de Cabello Hombre', '80.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Corte de Cabello Niño', '60.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Peinado Mujer', '80.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Peinado Hombre', '60.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Peinado Niño', '60.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Corte de Barba', '60.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Tinte Mujer', '300.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Uñas', '400.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Lavado de Cabello', '50.00');
INSERT INTO `appsalon_db`.`servicios` (`nombre`, `precio`) VALUES ('Tratamiento Capilar', '150.00');

CREATE TABLE `appsalon_db`.`citas` (
  `id` INT(11) NOT NULL,
  `fecha` DATE NULL,
  `hora` TIME NULL,
  `usuarioId` INT(11) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `usuarioId`
    FOREIGN KEY (`id`)
    REFERENCES `appsalon_db`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE `appsalon_db`.`citasservicios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `citaId` INT(11) NULL,
  `servicioId` INT(11) NULL,
  PRIMARY KEY (`id`),
  INDEX `citaId_idx` (`citaId` ASC) VISIBLE,
  INDEX `servicioId_idx` (`servicioId` ASC) VISIBLE,
  CONSTRAINT `citaId`
    FOREIGN KEY (`citaId`)
    REFERENCES `appsalon_db`.`citas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `servicioId`
    FOREIGN KEY (`servicioId`)
    REFERENCES `appsalon_db`.`servicios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `appsalon_db`.`citas` 
ADD INDEX `usuarioId_idx` (`usuarioId` ASC) VISIBLE;
;
ALTER TABLE `appsalon_db`.`citas` 
ADD CONSTRAINT `usuarioId`
  FOREIGN KEY (`usuarioId`)
  REFERENCES `appsalon_db`.`usuarios` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `appsalon_db`.`citas` 
DROP FOREIGN KEY `usuarioId`;
ALTER TABLE `appsalon_db`.`citas` 
ADD CONSTRAINT `usuarioId`
  FOREIGN KEY (`usuarioId`)
  REFERENCES `appsalon_db`.`usuarios` (`id`)
  ON DELETE SET NULL
  ON UPDATE SET NULL;

ALTER TABLE `appsalon_db`.`citasservicios` 
DROP FOREIGN KEY `citaId`,
DROP FOREIGN KEY `servicioId`;
ALTER TABLE `appsalon_db`.`citasservicios` 
ADD CONSTRAINT `citaId`
  FOREIGN KEY (`citaId`)
  REFERENCES `appsalon_db`.`citas` (`id`)
  ON DELETE SET NULL
  ON UPDATE SET NULL,
ADD CONSTRAINT `servicioId`
  FOREIGN KEY (`servicioId`)
  REFERENCES `appsalon_db`.`servicios` (`id`)
  ON DELETE SET NULL
  ON UPDATE SET NULL;
  
  ALTER TABLE `appsalon_db`.`usuarios` 
ADD COLUMN `password` VARCHAR(60) NULL AFTER `email`;

SHOW CREATE TABLE citasservicios;

SHOW CREATE TABLE citas;
SHOW CREATE TABLE citasservicios;

ALTER TABLE citasservicios
DROP FOREIGN KEY citaId;

ALTER TABLE citas
MODIFY id INT NOT NULL AUTO_INCREMENT;

ALTER TABLE citasservicios
MODIFY citaId INT DEFAULT NULL;

ALTER TABLE citasservicios
ADD CONSTRAINT citaId
FOREIGN KEY (citaId) REFERENCES citas(id)
ON DELETE SET NULL
ON UPDATE SET NULL;


  
  




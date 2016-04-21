-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema buenasPracticas
-- -----------------------------------------------------
SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_personal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_personal` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NULL,
  `usuario` VARCHAR(50) NULL,
  `clave` VARCHAR(255) NULL,
  `email` VARCHAR(45) NULL,
  `fechaCreado` DATETIME NULL,
  `fechaClaveUpdate` DATETIME NULL,
  `nota` VARCHAR(45) NULL,
  `esSuperAdmin` TINYINT(1) NULL,
  `correoNotificacionCadaXHoras` INT(2) UNSIGNED NULL DEFAULT 4,
  `correoUltimoEnviado` DATE NULL,
  `ultimoLogin` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_empresas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_empresas` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombreEmpresa` VARCHAR(4255) NULL,
  `calle` VARCHAR(255) NULL,
  `noExt` VARCHAR(100) NULL,
  `noInt` VARCHAR(100) NULL,
  `colonia` VARCHAR(100) NULL,
  `cp` VARCHAR(5) NULL,
  `ciudad` VARCHAR(150) NULL,
  `municipio` VARCHAR(3) NULL,
  `estado` VARCHAR(2) NULL,
  `ubicacion` POINT NULL,
  `contacto` VARCHAR(255) NULL,
  `telefono` VARCHAR(15) NULL,
  `correos` VARCHAR(150) NULL COMMENT 'direcciones de correo separadas por coma.',
  `sitioWeb` VARCHAR(150) NULL,
  `fechaCreacion` DATE NULL,
  `fechaActualizacion` TIMESTAMP NULL,
  `propietarioId` INT(11) UNSIGNED NULL,
  `mentorId` INT(11) UNSIGNED NULL,
  `publica` TINYINT(1) NULL,
  `contactoNombre` VARCHAR(45) NULL,
  `contactoTelefono` VARCHAR(45) NULL,
  `correoNotificacionCadaXHoras` INT(2) UNSIGNED NULL DEFAULT 4,
  `ultimoCorreoEnviado` DATE NULL,
  `ultimoLogin` DATE NULL DEFAULT NULL,
  `usuario` VARCHAR(50) NULL,
  `clave` VARCHAR(255) NULL,
  `fechaAutoevaluacion` DATE NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `personal_empresaId`
    FOREIGN KEY (`mentorId`)
    REFERENCES `bp_personal` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `personal_empresaId_idx` ON `bp_empresas` (`mentorId` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_categorias` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NULL,
  `orden` INT(2) NULL,
  `descripcion` TEXT NULL,
  `imagen1` VARCHAR(255) NULL,
  `imagen2` VARCHAR(255) NULL,
  `imagen3` VARCHAR(255) NULL,
  `imagenLiga` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_buenasPracticas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_buenasPracticas` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoriaId` INT(11) UNSIGNED NULL,
  `titulo` VARCHAR(255) NULL,
  `tituloCorto` VARCHAR(150) NULL,
  `descripcion` TEXT NULL,
  `experiencia` TEXT NULL,
  `sustentabilidad` TEXT NULL,
  `competitividad` TEXT NULL,
  `variaciones` TEXT NULL,
  `recursos` TEXT NULL,
  `aprenderMas` TEXT NULL,
  `criterios` TEXT NULL,
  `propietarioId` INT(11) UNSIGNED NULL,
  `fechaCreacion` DATE NULL,
  `fechaActualizacion` TIMESTAMP NULL,
  `publico` TINYINT(1) NULL,
  `imagen1` VARCHAR(255) NULL,
  `imagen2` VARCHAR(255) NULL,
  `imagen3` VARCHAR(255) NULL,
  `valorDeCertificacion` INT(11) NULL,
  `orden` INT(2) NULL,
  `puntosMaximos` DECIMAL(4,2) UNSIGNED NULL,
  `periodoDeVigencia` INT(11) NULL COMMENT 'periodo de vigencia en días. Después debe efectuarse el proceso de renovación ',
  `variacionesDePractica` TEXT NULL,
  `ANPAplicacion` TEXT NULL,
  `ejemplosCumplimiento` TEXT NULL COMMENT 'poner como lista con ligas a documentos',
  PRIMARY KEY (`id`),
  CONSTRAINT `categoriaId_buenasPracticas`
    FOREIGN KEY (`categoriaId`)
    REFERENCES `bp_categorias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `categoriaId_buenasPracticas_idx` ON `bp_buenasPracticas` (`categoriaId` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_empresa_buenaPractica`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_empresa_buenaPractica` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresaId` INT(11) UNSIGNED NULL,
  `buenasPracticasId` INT(11) UNSIGNED NULL,
  `estatus` ENUM('En proceso', 'Aprobada', 'No aprobada', 'Vencida') NULL,
  `fechaIncio` DATE NULL COMMENT 'es la fecha en la que la empresa registra la practica y tiene 3 meses para aprobarla.',
  `fechaAprobacion` DATE NULL COMMENT 'fecha en que se aprobó la practica. redundante del log que esta en la tabla bp_compania_buenaPractica_eventos',
  PRIMARY KEY (`id`),
  CONSTRAINT `empresaId_empresa_buenaPractica`
    FOREIGN KEY (`empresaId`)
    REFERENCES `bp_empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `buenasPracticasId_empresa_buenaPractica`
    FOREIGN KEY (`buenasPracticasId`)
    REFERENCES `bp_buenasPracticas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `empresaId_empresa_buenaPractica_idx` ON `bp_empresa_buenaPractica` (`empresaId` ASC);

SHOW WARNINGS;
CREATE INDEX `buenasPracticasId_empresa_buenaPractica_idx` ON `bp_empresa_buenaPractica` (`buenasPracticasId` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_criterios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_criterios` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `buenaPracticaId` INT(11) UNSIGNED NOT NULL,
  `nombre` VARCHAR(255) NULL,
  `puntos` DECIMAL(4,2) UNSIGNED NULL,
  `orden` INT(2) NULL,
  `orientacionMentor` TEXT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `buenaPracticaId_criterios`
    FOREIGN KEY (`buenaPracticaId`)
    REFERENCES `bp_buenasPracticas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `buenaPracticaId_criterios_idx` ON `bp_criterios` (`buenaPracticaId` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_catStatus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_catStatus` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NULL,
  `orden` TINYINT(1) UNSIGNED NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_catTipoEvidencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_catTipoEvidencia` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NULL,
  `orden` TINYINT(1) UNSIGNED NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_empresa_buenaPractica_eventos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_empresa_buenaPractica_eventos` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipoDeEvento` ENUM('Agregar evidencia', 'Evaluacion') NULL,
  `empresa_buenaPracticaId` INT(11) UNSIGNED NOT NULL,
  `criterioId` INT(11) UNSIGNED NOT NULL,
  `fecha` TIMESTAMP NULL,
  `nombreEvidencia` VARCHAR(255) NULL,
  `tipoEvidencia` INT(11) UNSIGNED NULL,
  `estatusBuenaPractica` INT(11) UNSIGNED NULL,
  `estatusCriterio` INT(11) UNSIGNED NULL,
  `estatusRequisito` INT(11) UNSIGNED NULL,
  `mensaje` VARCHAR(255) NULL COMMENT 'habilitado solo para los mentores como mensajes a las empresas',
  `prioridad` TINYINT(1) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `empresa_buenaPractica_empresa_buenaPractica_eventos`
    FOREIGN KEY (`empresa_buenaPracticaId`)
    REFERENCES `bp_empresa_buenaPractica` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `actividadId_empresa_buenaPractica_eventoss`
    FOREIGN KEY (`criterioId`)
    REFERENCES `bp_criterios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `empresa_buenaPractica_eventosStatusBuenaPractica_catStatus`
    FOREIGN KEY (`estatusBuenaPractica`)
    REFERENCES `bp_catStatus` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `empresa_buenaPractica_eventosStatusCriterio_catStatus`
    FOREIGN KEY (`estatusCriterio`)
    REFERENCES `bp_catStatus` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `empresa_buenaPractica_eventosStatusRequisito_catStatus`
    FOREIGN KEY (`estatusRequisito`)
    REFERENCES `bp_catStatus` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `empresa_buenaPractica_eventos_catTipoEvidencia`
    FOREIGN KEY (`tipoEvidencia`)
    REFERENCES `bp_catTipoEvidencia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `empresa_buenaPracticaId_empresa_buenaPractica_eventos_idx` ON `bp_empresa_buenaPractica_eventos` (`empresa_buenaPracticaId` ASC);

SHOW WARNINGS;
CREATE INDEX `actividadId_empresa_buenaPractica_evento_idx` ON `bp_empresa_buenaPractica_eventos` (`criterioId` ASC);

SHOW WARNINGS;
CREATE INDEX `fk_bp_empresa_buenaPractica_eventos_bp_catStatus1_idx` ON `bp_empresa_buenaPractica_eventos` (`estatusBuenaPractica` ASC);

SHOW WARNINGS;
CREATE INDEX `empresa_buenaPractica_eventosStatusCriterio_catStatus_idx` ON `bp_empresa_buenaPractica_eventos` (`estatusCriterio` ASC);

SHOW WARNINGS;
CREATE INDEX `empresa_buenaPractica_eventosStatusRequisito_catStatus_idx` ON `bp_empresa_buenaPractica_eventos` (`estatusRequisito` ASC);

SHOW WARNINGS;
CREATE INDEX `fk_bp_empresa_buenaPractica_eventos_bp_catTipoEvidencia1_idx` ON `bp_empresa_buenaPractica_eventos` (`tipoEvidencia` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_logActividades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_logActividades` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT(11) UNSIGNED NULL,
  `idPersonal` INT(11) UNSIGNED NULL,
  `fecha` TIMESTAMP NULL,
  `mensaje` VARCHAR(255) NULL,
  `prioridad` TINYINT(1) NULL COMMENT 'Poner items \nprioridades\n\n1 - Error\n2 - Warning\n3 - Info\n4 - \n5 - Debug',
  PRIMARY KEY (`id`),
  CONSTRAINT `logActividades_empresaId`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `bp_empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `logActividades_personalId`
    FOREIGN KEY (`idPersonal`)
    REFERENCES `bp_personal` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `logActividades_empresaId_idx` ON `bp_logActividades` (`idEmpresa` ASC);

SHOW WARNINGS;
CREATE INDEX `logActividades_personalId_idx` ON `bp_logActividades` (`idPersonal` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_preguntasAutoevaluacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_preguntasAutoevaluacion` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta` TEXT NULL COMMENT '		',
  `puntos` DECIMAL(4,2) UNSIGNED NULL,
  `activo` TINYINT(1) NULL,
  `orden` INT(10) UNSIGNED NULL,
  `idBuenaPractica` INT(11) UNSIGNED NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `preguntasAutoevaluacion_buenasPracticas`
    FOREIGN KEY (`idBuenaPractica`)
    REFERENCES `bp_buenasPracticas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `preguntasAutoevaluacion_buenasPracticas_idx` ON `bp_preguntasAutoevaluacion` (`idBuenaPractica` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bp_empresaResultadoAutoevaluacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bp_empresaResultadoAutoevaluacion` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT(11) UNSIGNED NULL,
  `idPregunta` INT(11) UNSIGNED NULL,
  `respuesta` TINYINT(1) NULL COMMENT '1 -si\n0 - no\n-1 - no se',
  PRIMARY KEY (`id`),
  CONSTRAINT `empresaResultado_empresas2`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `bp_empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `empresaResultado_preguntasAutoevaluacion2`
    FOREIGN KEY (`idPregunta`)
    REFERENCES `bp_preguntasAutoevaluacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `empresaResultado_empresas_idx` ON `bp_empresaResultadoAutoevaluacion` (`idEmpresa` ASC);

SHOW WARNINGS;
CREATE INDEX `empresaResultado_preguntasAutoevaluacion_idx` ON `bp_empresaResultadoAutoevaluacion` (`idPregunta` ASC);

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

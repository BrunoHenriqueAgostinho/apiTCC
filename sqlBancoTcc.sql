-- MySQL Script generated by MySQL Workbench
-- Mon Nov  1 08:34:54 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema academic
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema academic
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `academic` DEFAULT CHARACTER SET utf8;
USE `academic`;

-- -----------------------------------------------------
-- Table `academic`.`Tb_Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic`.`Tb_Usuario` (
  `cpf_usuario` CHAR(11) NOT NULL,
  `nome_usuario` VARCHAR(60) NOT NULL,
  `senha_usuario` VARCHAR(32) NOT NULL,
  `descricao_usuario` VARCHAR(255) NULL,
  `foto_usuario` VARCHAR(60) NULL,
  `dtCadastro_usuario` DATE NOT NULL,
  `tema_usuario` VARCHAR(40) NOT NULL DEFAULT 'lIGHT',
  `status_usuario` INT NOT NULL DEFAULT 1,
  `contaStatus_usuario` INT NOT NULL DEFAULT 1,
  `email_usuario` VARCHAR(60) NOT NULL,
  `telefoneFixo_usuario` CHAR(10) NULL,
  `telefoneCelular_usuario` CHAR(11) NULL,
  PRIMARY KEY (`cpf_usuario`),
  UNIQUE INDEX `cpf_usuario_UNIQUE` (`cpf_usuario` ASC),
  UNIQUE INDEX `email_usuario_UNIQUE` (`email_usuario` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academic`.`Tb_Instituicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic`.`Tb_Instituicao` (
  `cnpj_instituicao` CHAR(14) NOT NULL,
  `nome_instituicao` VARCHAR(60) NOT NULL,
  `logotipo_instituicao` VARCHAR(60) NULL,
  `dtCadastro_instituicao` DATE NOT NULL,
  `senha_instituicao` VARCHAR(32) NOT NULL,
  `contaStatus_instituicao` INT NOT NULL DEFAULT 1,
  `email_instituicao` VARCHAR(60) NOT NULL,
  `telefoneFixo_instituicao` CHAR(10) NULL,
  `telefoneCelular_instituicao` CHAR(11) NULL,
  `cidade_instituicao` VARCHAR(60) NULL,
  PRIMARY KEY (`cnpj_instituicao`),
  UNIQUE INDEX `cnpj_instituicao_UNIQUE` (`cnpj_instituicao` ASC),
  UNIQUE INDEX `email_instituicao_UNIQUE` (`email_instituicao` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academic`.`Tb_Modelo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic`.`Tb_Modelo` (
  `codigo_modelo` INT NOT NULL AUTO_INCREMENT,
  `nome_modelo` VARCHAR(150) NOT NULL,
  `arquivo_modelo` LONGTEXT NOT NULL,
  `dtCriacao_modelo` DATE NOT NULL,
  `descricao_modelo` VARCHAR(255) NULL,
  `Tb_Instituicao_cnpj_instituicao` CHAR(14) NULL,
  `margemDireita_modelo` VARCHAR(10) NULL,
  `margemEsquerda_modelo` VARCHAR(10) NULL,
  `margemTopo_modelo` VARCHAR(10) NULL,
  `margemBaixo_modelo` VARCHAR(10) NULL,
  PRIMARY KEY (`codigo_modelo`),
  INDEX `fk_Tb_Modelo_Tb_Instituicao1_idx` (`Tb_Instituicao_cnpj_instituicao` ASC),
  CONSTRAINT `fk_Tb_Modelo_Tb_Instituicao1`
    FOREIGN KEY (`Tb_Instituicao_cnpj_instituicao`)
    REFERENCES `academic`.`Tb_Instituicao` (`cnpj_instituicao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academic`.`Tb_Trabalho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic`.`Tb_Trabalho` (
  `codigo_trabalho` INT NOT NULL AUTO_INCREMENT,
  `nome_trabalho` VARCHAR(150) NOT NULL,
  `descricao_trabalho` VARCHAR(255) NULL,
  `arquivo_trabalho` LONGTEXT NOT NULL,
  `finalizado_trabalho` TINYINT NOT NULL DEFAULT 0,
  `dtCriacao_trabalho` DATE NOT NULL,
  `dtAlteracao_trabalho` DATE NOT NULL,
  `dtPublicacao_trabalho` DATE NULL,
  `avaliacao_trabalho` INT NULL,
  `Tb_Modelo_codigo_modelo` INT NOT NULL,
  `Tb_Instituicao_cnpj_instituicao` CHAR(14) NULL,
  `margemDireita_trabalho` VARCHAR(10) NULL,
  `margemEsquerda_trabalho` VARCHAR(10) NULL,
  `margemTopo_trabalho` VARCHAR(10) NULL,
  `margemBaixo_trabalho` VARCHAR(10) NULL,
  PRIMARY KEY (`codigo_trabalho`),
  INDEX `fk_Tb_Trabalho_Tb_Modelo1_idx` (`Tb_Modelo_codigo_modelo` ASC),
  INDEX `fk_Tb_Trabalho_Tb_Instituicao1_idx` (`Tb_Instituicao_cnpj_instituicao` ASC),
  CONSTRAINT `fk_Tb_Trabalho_Tb_Modelo1`
    FOREIGN KEY (`Tb_Modelo_codigo_modelo`)
    REFERENCES `academic`.`Tb_Modelo` (`codigo_modelo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Trabalho_Tb_Instituicao1`
    FOREIGN KEY (`Tb_Instituicao_cnpj_instituicao`)
    REFERENCES `academic`.`Tb_Instituicao` (`cnpj_instituicao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academic`.`Desenvolve_Usuario_Trabalho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic`.`Desenvolve_Usuario_Trabalho` (
  `Tb_Usuario_cpf_usuario` CHAR(11) NOT NULL,
  `Tb_Trabalho_codigo_trabalho` INT NOT NULL,
  `cargo_usuario` INT NOT NULL,
  PRIMARY KEY (`Tb_Usuario_cpf_usuario`, `Tb_Trabalho_codigo_trabalho`),
  INDEX `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Trabalho1_idx` (`Tb_Trabalho_codigo_trabalho` ASC),
  INDEX `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Usuario_idx` (`Tb_Usuario_cpf_usuario` ASC),
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Usuario`
    FOREIGN KEY (`Tb_Usuario_cpf_usuario`)
    REFERENCES `academic`.`Tb_Usuario` (`cpf_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Trabalho1`
    FOREIGN KEY (`Tb_Trabalho_codigo_trabalho`)
    REFERENCES `academic`.`Tb_Trabalho` (`codigo_trabalho`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academic`.`Reage_Usuario_Trabalho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic`.`Reage_Usuario_Trabalho` (
  `Tb_Usuario_cpf_usuario` CHAR(11) NOT NULL,
  `Tb_Trabalho_codigo_trabalho` INT NOT NULL,
  PRIMARY KEY (`Tb_Usuario_cpf_usuario`, `Tb_Trabalho_codigo_trabalho`),
  INDEX `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Trabalho2_idx` (`Tb_Trabalho_codigo_trabalho` ASC),
  INDEX `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Usuario1_idx` (`Tb_Usuario_cpf_usuario` ASC),
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Usuario1`
    FOREIGN KEY (`Tb_Usuario_cpf_usuario`)
    REFERENCES `academic`.`Tb_Usuario` (`cpf_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Trabalho2`
    FOREIGN KEY (`Tb_Trabalho_codigo_trabalho`)
    REFERENCES `academic`.`Tb_Trabalho` (`codigo_trabalho`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academic`.`Adiciona_Usuario_Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic`.`Adiciona_Usuario_Usuario` (
  `seguidor_usuario` CHAR(11) NOT NULL,
  `seguido_usuario` CHAR(11) NOT NULL,
  PRIMARY KEY (`seguidor_usuario`, `seguido_usuario`),
  INDEX `fk_Tb_Usuario_has_Tb_Usuario_Tb_Usuario2_idx` (`seguido_usuario` ASC),
  INDEX `fk_Tb_Usuario_has_Tb_Usuario_Tb_Usuario1_idx` (`seguidor_usuario` ASC),
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Usuario_Tb_Usuario1`
    FOREIGN KEY (`seguidor_usuario`)
    REFERENCES `academic`.`Tb_Usuario` (`cpf_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Usuario_Tb_Usuario2`
    FOREIGN KEY (`seguido_usuario`)
    REFERENCES `academic`.`Tb_Usuario` (`cpf_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academic`.`Tb_Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic`.`Tb_Tag` (
  `codigo_tag` INT NOT NULL AUTO_INCREMENT,
  `categoria_tag` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`codigo_tag`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academic`.`Apresenta_Trabalho_Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic`.`Apresenta_Trabalho_Tag` (
  `Tb_Trabalho_codigo_trabalho` INT NOT NULL,
  `Tb_Tag_codigo_tag` INT NOT NULL,
  PRIMARY KEY (`Tb_Trabalho_codigo_trabalho`, `Tb_Tag_codigo_tag`),
  INDEX `fk_Tb_Trabalho_has_Tb_Tag_Tb_Tag1_idx` (`Tb_Tag_codigo_tag` ASC),
  INDEX `fk_Tb_Trabalho_has_Tb_Tag_Tb_Trabalho1_idx` (`Tb_Trabalho_codigo_trabalho` ASC),
  CONSTRAINT `fk_Tb_Trabalho_has_Tb_Tag_Tb_Trabalho1`
    FOREIGN KEY (`Tb_Trabalho_codigo_trabalho`)
    REFERENCES `academic`.`Tb_Trabalho` (`codigo_trabalho`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Trabalho_has_Tb_Tag_Tb_Tag1`
    FOREIGN KEY (`Tb_Tag_codigo_tag`)
    REFERENCES `academic`.`Tb_Tag` (`codigo_tag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

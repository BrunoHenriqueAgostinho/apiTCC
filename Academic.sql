-- MySQL Script generated by MySQL Workbench
-- Thu Aug 12 14:51:24 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema Academic2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Academic2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Academic2` DEFAULT CHARACTER SET utf8 ;
USE `Academic2` ;

-- -----------------------------------------------------
-- Table `Academic2`.`Tb_contato`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Tb_contato` (
  `codigo_contato` INT NOT NULL AUTO_INCREMENT,
  `email_contato` VARCHAR(60) NOT NULL,
  `telefoneFixo_contato` CHAR(10) NULL,
  `telefoneCelular_contato` CHAR(11) NULL,
  PRIMARY KEY (`codigo_contato`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Tb_Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Tb_Usuario` (
  `cpf_usuario` CHAR(11) NOT NULL,
  `nome_usuario` VARCHAR(60) NOT NULL,
  `senha_usuario` VARCHAR(25) NOT NULL,
  `descricao_usuario` VARCHAR(255) NULL,
  `foto_usuario` VARCHAR(60) NULL,
  `dtCadastro_usuario` DATE NOT NULL,
  `tema_usuario` INT NOT NULL DEFAULT 1,
  `status_usuario` INT NOT NULL DEFAULT 1,
  `Tb_Contato_codigo_contato` INT NOT NULL,
  UNIQUE INDEX `cpf_usuario_UNIQUE` (`cpf_usuario` ASC),
  PRIMARY KEY (`cpf_usuario`),
  INDEX `fk_Tb_Usuario_Tb_Contato1_idx` (`Tb_Contato_codigo_contato` ASC),
  CONSTRAINT `fk_Tb_Usuario_Tb_Contato1`
    FOREIGN KEY (`Tb_Contato_codigo_contato`)
    REFERENCES `Academic2`.`Tb_contato` (`codigo_contato`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Tb_Instituicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Tb_Instituicao` (
  `cnpj_instituicao` CHAR(14) NOT NULL,
  `nome_instituicao` VARCHAR(60) NOT NULL,
  `logotipo_instituicao` VARCHAR(60) NULL,
  `dtCadastro_instituicao` DATE NOT NULL,
  `senha_instituicao` VARCHAR(25) NOT NULL,
  `Tb_Contato_codigo_contato` INT NOT NULL,
  UNIQUE INDEX `cnpj_instituicao_UNIQUE` (`cnpj_instituicao` ASC),
  PRIMARY KEY (`cnpj_instituicao`),
  INDEX `fk_Tb_Instituicao_Tb_Contato1_idx` (`Tb_Contato_codigo_contato` ASC),
  CONSTRAINT `fk_Tb_Instituicao_Tb_Contato1`
    FOREIGN KEY (`Tb_Contato_codigo_contato`)
    REFERENCES `Academic2`.`Tb_contato` (`codigo_contato`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Tb_Modelo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Tb_Modelo` (
  `codigo_modelo` INT NOT NULL AUTO_INCREMENT,
  `nome_modelo` VARCHAR(60) NOT NULL,
  `arquivo_modelo` LONGTEXT NOT NULL,
  `formatacao_modelo` VARCHAR(255) NOT NULL,
  `dtCriacao_modelo` DATE NOT NULL,
  `descricao_modelo` VARCHAR(255) NULL,
  `Tb_Instituicao_cnpj_instituicao` CHAR(14) NULL,
  PRIMARY KEY (`codigo_modelo`),
  INDEX `fk_Tb_Modelo_Tb_Instituicao1_idx` (`Tb_Instituicao_cnpj_instituicao` ASC),
  CONSTRAINT `fk_Tb_Modelo_Tb_Instituicao1`
    FOREIGN KEY (`Tb_Instituicao_cnpj_instituicao`)
    REFERENCES `Academic2`.`Tb_Instituicao` (`cnpj_instituicao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Tb_Trabalho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Tb_Trabalho` (
  `codigo_trabalho` INT NOT NULL AUTO_INCREMENT,
  `nome_trabalho` VARCHAR(60) NOT NULL,
  `descricao_trabalho` VARCHAR(255) NULL,
  `arquivo_trabalho` LONGTEXT NOT NULL,
  `formatacao_trabalho` VARCHAR(255) NOT NULL,
  `finalizado_trabalho` TINYINT NOT NULL DEFAULT 0,
  `dtCriacao_trabalho` DATE NOT NULL,
  `dtAlteracao_trabalho` DATE NOT NULL,
  `dtPublicacao_trabalho` DATE NULL,
  `avaliacao_trabalho` INT NULL,
  `Tb_Instituicao_cnpj_instituicao` CHAR(14) NULL,
  `Tb_Modelo_codigo_modelo` INT NOT NULL,
  PRIMARY KEY (`codigo_trabalho`),
  INDEX `fk_Tb_Trabalho_Tb_Instituicao1_idx` (`Tb_Instituicao_cnpj_instituicao` ASC),
  INDEX `fk_Tb_Trabalho_Tb_Modelo1_idx` (`Tb_Modelo_codigo_modelo` ASC),
  CONSTRAINT `fk_Tb_Trabalho_Tb_Instituicao1`
    FOREIGN KEY (`Tb_Instituicao_cnpj_instituicao`)
    REFERENCES `Academic2`.`Tb_Instituicao` (`cnpj_instituicao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Trabalho_Tb_Modelo1`
    FOREIGN KEY (`Tb_Modelo_codigo_modelo`)
    REFERENCES `Academic2`.`Tb_Modelo` (`codigo_modelo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Desenvolve_Usuario_Trabalho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Desenvolve_Usuario_Trabalho` (
  `Tb_Usuario_cpf_usuario` CHAR(11) NOT NULL,
  `Tb_Trabalho_codigo_trabalho` INT NOT NULL,
  `cargo_usuario` INT NOT NULL,
  PRIMARY KEY (`Tb_Usuario_cpf_usuario`, `Tb_Trabalho_codigo_trabalho`),
  INDEX `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Trabalho1_idx` (`Tb_Trabalho_codigo_trabalho` ASC),
  INDEX `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Usuario_idx` (`Tb_Usuario_cpf_usuario` ASC),
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Usuario`
    FOREIGN KEY (`Tb_Usuario_cpf_usuario`)
    REFERENCES `Academic2`.`Tb_Usuario` (`cpf_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Trabalho1`
    FOREIGN KEY (`Tb_Trabalho_codigo_trabalho`)
    REFERENCES `Academic2`.`Tb_Trabalho` (`codigo_trabalho`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Reage_Usuario_Trabalho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Reage_Usuario_Trabalho` (
  `Tb_Usuario_cpf_usuario` CHAR(11) NOT NULL,
  `Tb_Trabalho_codigo_trabalho` INT NOT NULL,
  PRIMARY KEY (`Tb_Usuario_cpf_usuario`, `Tb_Trabalho_codigo_trabalho`),
  INDEX `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Trabalho2_idx` (`Tb_Trabalho_codigo_trabalho` ASC),
  INDEX `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Usuario1_idx` (`Tb_Usuario_cpf_usuario` ASC),
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Usuario1`
    FOREIGN KEY (`Tb_Usuario_cpf_usuario`)
    REFERENCES `Academic2`.`Tb_Usuario` (`cpf_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Trabalho_Tb_Trabalho2`
    FOREIGN KEY (`Tb_Trabalho_codigo_trabalho`)
    REFERENCES `Academic2`.`Tb_Trabalho` (`codigo_trabalho`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Adiciona_Usuario_Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Adiciona_Usuario_Usuario` (
  `seguidor_usuario` CHAR(11) NOT NULL,
  `seguido_usuario` CHAR(11) NOT NULL,
  PRIMARY KEY (`seguidor_usuario`, `seguido_usuario`),
  INDEX `fk_Tb_Usuario_has_Tb_Usuario_Tb_Usuario2_idx` (`seguido_usuario` ASC),
  INDEX `fk_Tb_Usuario_has_Tb_Usuario_Tb_Usuario1_idx` (`seguidor_usuario` ASC),
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Usuario_Tb_Usuario1`
    FOREIGN KEY (`seguidor_usuario`)
    REFERENCES `Academic2`.`Tb_Usuario` (`cpf_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Usuario_has_Tb_Usuario_Tb_Usuario2`
    FOREIGN KEY (`seguido_usuario`)
    REFERENCES `Academic2`.`Tb_Usuario` (`cpf_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Tb_Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Tb_Tag` (
  `codigo_tag` INT NOT NULL AUTO_INCREMENT,
  `categoria_tag` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`codigo_tag`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Apresenta_Trabalho_Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Apresenta_Trabalho_Tag` (
  `Tb_Trabalho_codigo_trabalho` INT NOT NULL,
  `Tb_Tag_codigo_tag` INT NOT NULL,
  PRIMARY KEY (`Tb_Trabalho_codigo_trabalho`, `Tb_Tag_codigo_tag`),
  INDEX `fk_Tb_Trabalho_has_Tb_Tag_Tb_Tag1_idx` (`Tb_Tag_codigo_tag` ASC),
  INDEX `fk_Tb_Trabalho_has_Tb_Tag_Tb_Trabalho1_idx` (`Tb_Trabalho_codigo_trabalho` ASC),
  CONSTRAINT `fk_Tb_Trabalho_has_Tb_Tag_Tb_Trabalho1`
    FOREIGN KEY (`Tb_Trabalho_codigo_trabalho`)
    REFERENCES `Academic2`.`Tb_Trabalho` (`codigo_trabalho`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tb_Trabalho_has_Tb_Tag_Tb_Tag1`
    FOREIGN KEY (`Tb_Tag_codigo_tag`)
    REFERENCES `Academic2`.`Tb_Tag` (`codigo_tag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Academic2`.`Tb_Endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Academic2`.`Tb_Endereco` (
  `Tb_Instituicao_cnpj_instituicao` CHAR(14) NOT NULL,
  `estado_endereco` VARCHAR(60) NOT NULL,
  `cidade_endereco` VARCHAR(60) NOT NULL,
  `bairro_endereco` VARCHAR(60) NOT NULL,
  `rua_endereco` VARCHAR(60) NOT NULL,
  `numero_endereco` VARCHAR(10) NOT NULL,
  `complemento_endereco` VARCHAR(60) NULL,
  `cep_endereco` CHAR(8) NOT NULL,
  PRIMARY KEY (`Tb_Instituicao_cnpj_instituicao`),
  CONSTRAINT `fk_table1_Tb_Instituicao1`
    FOREIGN KEY (`Tb_Instituicao_cnpj_instituicao`)
    REFERENCES `Academic2`.`Tb_Instituicao` (`cnpj_instituicao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

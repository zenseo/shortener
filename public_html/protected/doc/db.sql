DROP SCHEMA IF EXISTS `shortener` ;
CREATE SCHEMA IF NOT EXISTS `shortener` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `shortener` ;

-- -----------------------------------------------------
-- Table `shorter`.`links`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shortener`.`link` (
  `id` VARCHAR(6) NOT NULL COMMENT 'Shortened link',
  `hash` VARCHAR(40) NOT NULL COMMENT 'Hash',
  `url` VARCHAR(1000) NOT NULL COMMENT 'Link',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `hash_UNIQUE` (`hash` ASC),
  INDEX `hash_IDX` (`hash` ASC))
ENGINE = InnoDB;
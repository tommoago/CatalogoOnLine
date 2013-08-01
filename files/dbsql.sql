SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `melarossa` DEFAULT CHARACTER SET utf8 ;
USE `melarossa` ;

-- -----------------------------------------------------
-- Table `melarossa`.`categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `melarossa`.`products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NULL ,
  `new` TINYINT(1) NULL ,
  `offer` TINYINT(1) NULL ,
  `evidence` TINYINT(1) NULL ,
  `categories_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `categories_id`) ,
  INDEX `fk_products_categories_idx` (`categories_id` ASC) ,
  CONSTRAINT `fk_products_categories`
    FOREIGN KEY (`categories_id` )
    REFERENCES `melarossa`.`categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `melarossa`.`customers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`customers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `surname` VARCHAR(45) NULL ,
  `address` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `telephone` VARCHAR(45) NULL ,
  `cellphone` VARCHAR(45) NULL ,
  `customerscol` VARCHAR(45) NULL ,
  `active` TINYINT(1) NULL ,
  `password` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `melarossa`.`orders`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data` DATETIME NULL ,
  `customers_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `customers_id`) ,
  INDEX `fk_orders_customers1_idx` (`customers_id` ASC) ,
  CONSTRAINT `fk_orders_customers1`
    FOREIGN KEY (`customers_id` )
    REFERENCES `melarossa`.`customers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `melarossa`.`table5`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`table5` (
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `melarossa`.`orders_has_products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`orders_has_products` (
  `orders_id` INT NOT NULL ,
  `products_id` INT NOT NULL ,
  `quantity` INT NULL ,
  PRIMARY KEY (`orders_id`, `products_id`) ,
  INDEX `fk_orders_has_products_products1_idx` (`products_id` ASC) ,
  INDEX `fk_orders_has_products_orders1_idx` (`orders_id` ASC) ,
  CONSTRAINT `fk_orders_has_products_orders1`
    FOREIGN KEY (`orders_id` )
    REFERENCES `melarossa`.`orders` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_has_products_products1`
    FOREIGN KEY (`products_id` )
    REFERENCES `melarossa`.`products` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `melarossa` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

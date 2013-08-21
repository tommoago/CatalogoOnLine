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
  `categories_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `categories_id`) ,
  INDEX `fk_categories_categories1_idx` (`categories_id` ASC) ,
  CONSTRAINT `fk_categories_categories1`
    FOREIGN KEY (`categories_id` )
    REFERENCES `melarossa`.`categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `melarossa`.`products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NULL ,
  `description` TEXT NULL ,
  `new` TINYINT(1) NULL ,
  `offer` TINYINT(1) NULL ,
  `evidence` TINYINT(1) NULL ,
  `wholesale_price` DOUBLE NULL ,
  `retail_price` DOUBLE NULL ,
  `super_price` DOUBLE NULL ,
  `purchase_price` DOUBLE NULL ,
  `cod` VARCHAR(45) NULL ,
  `barcode` VARCHAR(45) NULL ,
  `single_qty` INT NULL ,
  `pack_qty` INT NULL ,
  `cardboard_qty` INT NULL ,
  `productscol` VARCHAR(45) NULL ,
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
-- Table `melarossa`.`administrators`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`administrators` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `user` VARCHAR(45) NULL ,
  `password` VARCHAR(45) NULL ,
  `role` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
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
  `administrators_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `administrators_id`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  INDEX `fk_customers_administrators1_idx` (`administrators_id` ASC) ,
  CONSTRAINT `fk_customers_administrators1`
    FOREIGN KEY (`administrators_id` )
    REFERENCES `melarossa`.`administrators` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `melarossa`.`orders`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data` DATETIME NULL ,
  `confirmed` TINYINT NULL ,
  `operator` VARCHAR(45) NULL ,
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


-- -----------------------------------------------------
-- Table `melarossa`.`product_images`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`product_images` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `path` VARCHAR(45) NULL ,
  `name` VARCHAR(45) NULL ,
  `products_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `products_id`) ,
  INDEX `fk_product_images_products1_idx` (`products_id` ASC) ,
  CONSTRAINT `fk_product_images_products1`
    FOREIGN KEY (`products_id` )
    REFERENCES `melarossa`.`products` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `melarossa`.`invoices`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `melarossa`.`invoices` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `path` VARCHAR(45) NULL ,
  `name` VARCHAR(45) NULL ,
  `orders_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `orders_id`) ,
  INDEX `fk_invoices_orders1_idx` (`orders_id` ASC) ,
  CONSTRAINT `fk_invoices_orders1`
    FOREIGN KEY (`orders_id` )
    REFERENCES `melarossa`.`orders` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `melarossa` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

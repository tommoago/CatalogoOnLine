SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `melarossa` DEFAULT CHARACTER SET utf8 ;
USE `melarossa` ;

-- -----------------------------------------------------
-- Table `melarossa`.`administrators`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `melarossa`.`administrators` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `user` VARCHAR(45) NULL DEFAULT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  `role` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `melarossa`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `melarossa`.`categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `categories_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_categories_categories1_idx` (`categories_id` ASC),
  CONSTRAINT `fk_categories_categories1`
    FOREIGN KEY (`categories_id`)
    REFERENCES `melarossa`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `melarossa`.`company_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `melarossa`.`company_info` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `description` VARCHAR(45) NULL DEFAULT NULL,
  `piva` VARCHAR(45) NULL DEFAULT NULL,
  `telephone` VARCHAR(45) NULL DEFAULT NULL,
  `fax` VARCHAR(45) NULL DEFAULT NULL,
  `address` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `melarossa`.`customers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `melarossa`.`customers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `surname` VARCHAR(45) NULL DEFAULT NULL,
  `address` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `telephone` VARCHAR(45) NULL DEFAULT NULL,
  `cellphone` VARCHAR(45) NULL DEFAULT NULL,
  `active` TINYINT(1) NULL DEFAULT NULL,
  `password` VARCHAR(45) NOT NULL,
  `type` VARCHAR(45) NULL DEFAULT NULL,
  `administrators_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `administrators_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_customers_administrators1_idx` (`administrators_id` ASC),
  CONSTRAINT `fk_customers_administrators1`
    FOREIGN KEY (`administrators_id`)
    REFERENCES `melarossa`.`administrators` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `melarossa`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `melarossa`.`orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `data` DATETIME NULL DEFAULT NULL,
  `confirmed` TINYINT(4) NULL DEFAULT NULL,
  `operator` VARCHAR(45) NULL DEFAULT NULL,
  `customers_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `customers_id`),
  INDEX `fk_orders_customers1_idx` (`customers_id` ASC),
  CONSTRAINT `fk_orders_customers1`
    FOREIGN KEY (`customers_id`)
    REFERENCES `melarossa`.`customers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `melarossa`.`invoices`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `melarossa`.`invoices` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(150) NULL DEFAULT NULL,
  `orders_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `orders_id`),
  INDEX `fk_invoices_orders1_idx` (`orders_id` ASC),
  CONSTRAINT `fk_invoices_orders1`
    FOREIGN KEY (`orders_id`)
    REFERENCES `melarossa`.`orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 33
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `melarossa`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `melarossa`.`products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `new` TINYINT(1) NULL DEFAULT NULL,
  `offer` TINYINT(1) NULL DEFAULT NULL,
  `evidence` TINYINT(1) NULL DEFAULT NULL,
  `wholesale_price` DOUBLE NULL DEFAULT NULL,
  `retail_price` DOUBLE NULL DEFAULT NULL,
  `super_price` DOUBLE NULL DEFAULT NULL,
  `purchase_price` DOUBLE NULL DEFAULT NULL,
  `cod` VARCHAR(45) NULL DEFAULT NULL,
  `barcode` VARCHAR(45) NULL DEFAULT NULL,
  `single_qty` INT(11) NULL DEFAULT NULL,
  `pack_qty` INT(11) NULL DEFAULT NULL,
  `cardboard_qty` INT(11) NULL DEFAULT NULL,
  `categories_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `categories_id`),
  INDEX `fk_products_categories_idx` (`categories_id` ASC),
  CONSTRAINT `fk_products_categories`
    FOREIGN KEY (`categories_id`)
    REFERENCES `melarossa`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 33
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `melarossa`.`orders_has_products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `melarossa`.`orders_has_products` (
  `orders_id` INT(11) NOT NULL,
  `products_id` INT(11) NOT NULL,
  `quantity` INT(11) NULL DEFAULT NULL,
  `sold_price` DOUBLE NULL DEFAULT NULL,
  PRIMARY KEY (`orders_id`, `products_id`),
  INDEX `fk_orders_has_products_products1_idx` (`products_id` ASC),
  INDEX `fk_orders_has_products_orders1_idx` (`orders_id` ASC),
  CONSTRAINT `fk_orders_has_products_orders1`
    FOREIGN KEY (`orders_id`)
    REFERENCES `melarossa`.`orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_has_products_products1`
    FOREIGN KEY (`products_id`)
    REFERENCES `melarossa`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `melarossa`.`product_images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `melarossa`.`product_images` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(100) NULL DEFAULT NULL,
  `products_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `products_id`),
  INDEX `fk_product_images_products1_idx` (`products_id` ASC),
  CONSTRAINT `fk_product_images_products1`
    FOREIGN KEY (`products_id`)
    REFERENCES `melarossa`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

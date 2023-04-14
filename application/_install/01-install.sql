SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `kraken` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `kraken` ;

-- -----------------------------------------------------
-- Table `kraken`.`user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(50) NOT NULL ,
  `last_name` VARCHAR(50) NULL ,
  `password_hash` VARCHAR(5000) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `birthdate` DATE NOT NULL ,
  `role` VARCHAR(45) NOT NULL ,
  `phone_number` VARCHAR(45) NOT NULL ,
  `is_active` TINYINT NULL DEFAULT 1 ,
  `gender` VARCHAR(45) NULL ,
  `image_url` VARCHAR(500) NOT NULL DEFAULT 'public\\img\\users\\default.jpg' ,
  `facebook_link` VARCHAR(500) NULL ,
  `twitter_link` VARCHAR(500) NULL ,
  `skype_link` VARCHAR(500) NULL ,
  `telegram_link` VARCHAR(500) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`teacher`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`teacher` (
  `user_id` INT NOT NULL ,
  `rating` INT NULL ,
  `degree` VARCHAR(5000) NOT NULL ,
  PRIMARY KEY (`user_id`) ,
  CONSTRAINT `fk_teacher_user`
    FOREIGN KEY (`user_id` )
    REFERENCES `kraken`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`student`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`student` (
  `user_id` INT NOT NULL ,
  `section` VARCHAR(100) NULL ,
  PRIMARY KEY (`user_id`) ,
  CONSTRAINT `fk_student_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `kraken`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`subject`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`subject` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `description` TEXT NULL ,
  `teacher_user_id` INT NOT NULL ,
  `max_students` INT NOT NULL ,
  `image_url` VARCHAR(45) NULL DEFAULT 'public\\img\\subjects\\default.png' ,
  `rating` INT NULL ,
  `category` VARCHAR(45) NULL ,
  `status` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_subject_teacher1_idx` (`teacher_user_id` ASC) ,
  CONSTRAINT `fk_subject_teacher1`
    FOREIGN KEY (`teacher_user_id` )
    REFERENCES `kraken`.`teacher` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`availability`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`availability` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `date` DATE NOT NULL ,
  `from` VARCHAR(45) NOT NULL ,
  `to` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`teacher_availability`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`teacher_availability` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `teacher_user_id` INT NOT NULL ,
  `availability_id` INT NOT NULL ,
  `is_availability_closed` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_teacher_has_availability_availability1_idx` (`availability_id` ASC) ,
  INDEX `fk_teacher_has_availability_teacher1_idx` (`teacher_user_id` ASC) ,
  CONSTRAINT `fk_teacher_has_availability_teacher1`
    FOREIGN KEY (`teacher_user_id` )
    REFERENCES `kraken`.`teacher` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_teacher_has_availability_availability1`
    FOREIGN KEY (`availability_id` )
    REFERENCES `kraken`.`availability` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`session`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`session` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `topic` VARCHAR(100) NULL ,
  `subject_id` INT NOT NULL ,
  `teacher_availability_id` INT NOT NULL ,
  `reject_reason` TEXT NULL ,
  `count` INT NOT NULL ,
  `status` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`, `teacher_availability_id`) ,
  INDEX `fk_session_subject1_idx` (`subject_id` ASC) ,
  INDEX `fk_session_teacher_availability1_idx` (`teacher_availability_id` ASC) ,
  CONSTRAINT `fk_session_subject1`
    FOREIGN KEY (`subject_id` )
    REFERENCES `kraken`.`subject` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_session_teacher_availability1`
    FOREIGN KEY (`teacher_availability_id` )
    REFERENCES `kraken`.`teacher_availability` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`student_session`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`student_session` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `student_user_id` INT NOT NULL ,
  `session_id` INT NOT NULL ,
  `rate` INT NULL ,
  `comment` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_student_has_session_session1_idx` (`session_id` ASC) ,
  INDEX `fk_student_has_session_student1_idx` (`student_user_id` ASC) ,
  CONSTRAINT `fk_student_has_session_student1`
    FOREIGN KEY (`student_user_id` )
    REFERENCES `kraken`.`student` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_has_session_session1`
    FOREIGN KEY (`session_id` )
    REFERENCES `kraken`.`session` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`notification`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`notification` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `header` VARCHAR(500) NOT NULL ,
  `body` TEXT NOT NULL ,
  `sender_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_notification_user1_idx` (`sender_id` ASC) ,
  CONSTRAINT `fk_notification_user1`
    FOREIGN KEY (`sender_id` )
    REFERENCES `kraken`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`notification`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`notification` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `header` VARCHAR(500) NOT NULL ,
  `body` TEXT NOT NULL ,
  `sender_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_notification_user1_idx` (`sender_id` ASC) ,
  CONSTRAINT `fk_notification_user1`
    FOREIGN KEY (`sender_id` )
    REFERENCES `kraken`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`user_notification`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`user_notification` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `recipient_id` INT NOT NULL ,
  `notification_id` INT NOT NULL ,
  `seen_date` DATETIME NULL ,
  `seen` TINYINT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_has_notification_notification1_idx` (`notification_id` ASC) ,
  INDEX `fk_user_has_notification_user1_idx` (`recipient_id` ASC) ,
  CONSTRAINT `fk_user_has_notification_user1`
    FOREIGN KEY (`recipient_id` )
    REFERENCES `kraken`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_notification_notification1`
    FOREIGN KEY (`notification_id` )
    REFERENCES `kraken`.`notification` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`user_notification`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`user_notification` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `recipient_id` INT NOT NULL ,
  `notification_id` INT NOT NULL ,
  `seen_date` DATETIME NULL ,
  `seen` TINYINT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_has_notification_notification1_idx` (`notification_id` ASC) ,
  INDEX `fk_user_has_notification_user1_idx` (`recipient_id` ASC) ,
  CONSTRAINT `fk_user_has_notification_user1`
    FOREIGN KEY (`recipient_id` )
    REFERENCES `kraken`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_notification_notification1`
    FOREIGN KEY (`notification_id` )
    REFERENCES `kraken`.`notification` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`friendship`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`friendship` (
  `student_user_id` INT NOT NULL ,
  `student_user_id1` INT NOT NULL ,
  `id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_student_has_student_student2_idx` (`student_user_id1` ASC) ,
  INDEX `fk_student_has_student_student1_idx` (`student_user_id` ASC) ,
  CONSTRAINT `fk_student_has_student_student1`
    FOREIGN KEY (`student_user_id` )
    REFERENCES `kraken`.`student` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_has_student_student2`
    FOREIGN KEY (`student_user_id1` )
    REFERENCES `kraken`.`student` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`student_teacher`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`student_teacher` (
  `student_user_id` INT NOT NULL ,
  `teacher_user_id` INT NOT NULL ,
  `id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_student_has_teacher_teacher1_idx` (`teacher_user_id` ASC) ,
  INDEX `fk_student_has_teacher_student1_idx` (`student_user_id` ASC) ,
  CONSTRAINT `fk_student_has_teacher_student1`
    FOREIGN KEY (`student_user_id` )
    REFERENCES `kraken`.`student` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_has_teacher_teacher1`
    FOREIGN KEY (`teacher_user_id` )
    REFERENCES `kraken`.`teacher` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kraken`.`message`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kraken`.`message` (
  `sender_id` INT NOT NULL ,
  `recipient_id` INT NOT NULL ,
  `message_body` TEXT NOT NULL ,
  `id` INT NOT NULL ,
  `message_time` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_has_user_user2_idx` (`recipient_id` ASC) ,
  INDEX `fk_user_has_user_user1_idx` (`sender_id` ASC) ,
  CONSTRAINT `fk_user_has_user_user1`
    FOREIGN KEY (`sender_id` )
    REFERENCES `kraken`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_user_user2`
    FOREIGN KEY (`recipient_id` )
    REFERENCES `kraken`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `kraken` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

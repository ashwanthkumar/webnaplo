SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `webnaplo` ;
CREATE SCHEMA IF NOT EXISTS `webnaplo` DEFAULT CHARACTER SET utf8 ;
USE `webnaplo` ;

-- -----------------------------------------------------
-- Table `webnaplo`.`Dept`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Dept` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Dept` (
  `iddept` BIGINT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(64) NULL ,
  PRIMARY KEY (`iddept`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`Programme`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Programme` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Programme` (
  `idprogramme` BIGINT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(128) NULL ,
  `dept_id` BIGINT NOT NULL ,
  PRIMARY KEY (`idprogramme`) ,
  INDEX `fk_programme_dept1` (`dept_id` ASC) ,
  CONSTRAINT `fk_programme_dept1`
    FOREIGN KEY (`dept_id` )
    REFERENCES `webnaplo`.`Dept` (`iddept` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`Class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Class` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Class` (
  `idclass` BIGINT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(15) NULL ,
  `programme_id` BIGINT NOT NULL ,
  PRIMARY KEY (`idclass`) ,
  INDEX `fk_class_programme1` (`programme_id` ASC) ,
  CONSTRAINT `fk_class_programme1`
    FOREIGN KEY (`programme_id` )
    REFERENCES `webnaplo`.`Programme` (`idprogramme` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`Student`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Student` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Student` (
  `idstudent` BIGINT NOT NULL ,
  `address` VARCHAR(45) NULL ,
  `current_semester` VARCHAR(10) NULL ,
  `email` VARCHAR(45) NULL ,
  `is_blocked` TINYINT NULL ,
  `mobile` VARCHAR(16) NULL ,
  `name` VARCHAR(15) NULL ,
  `password` VARCHAR(32) NULL ,
  `year` VARCHAR(10) NULL ,
  `class_id` BIGINT NOT NULL ,
  `last_login` TIMESTAMP NULL ,
  PRIMARY KEY (`idstudent`) ,
  INDEX `fk_student_class1` (`class_id` ASC) ,
  CONSTRAINT `fk_student_class1`
    FOREIGN KEY (`class_id` )
    REFERENCES `webnaplo`.`Class` (`idclass` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`Staff`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Staff` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Staff` (
  `idstaff` BIGINT NOT NULL AUTO_INCREMENT ,
  `address` TEXT NULL ,
  `designation` VARCHAR(128) NULL ,
  `email` VARCHAR(128) NULL ,
  `is_blocked` TINYINT NULL ,
  `mobile` VARCHAR(16) NULL ,
  `name` VARCHAR(128) NULL ,
  `password` VARCHAR(32) NULL ,
  `staff_id` VARCHAR(64) NULL ,
  `dept_id` BIGINT NOT NULL ,
  `last_login` TIMESTAMP NULL ,
  PRIMARY KEY (`idstaff`) ,
  INDEX `fk_staff_dept1` (`dept_id` ASC) ,
  CONSTRAINT `fk_staff_dept1`
    FOREIGN KEY (`dept_id` )
    REFERENCES `webnaplo`.`Dept` (`iddept` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`Course`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Course` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Course` (
  `idcourse` BIGINT NOT NULL AUTO_INCREMENT ,
  `course_code` VARCHAR(32) NULL ,
  `course_name` VARCHAR(128) NULL ,
  `credits` INT NULL ,
  `programme_id` BIGINT NOT NULL ,
  PRIMARY KEY (`idcourse`) ,
  INDEX `fk_Course_Programme1` (`programme_id` ASC) ,
  CONSTRAINT `fk_Course_Programme1`
    FOREIGN KEY (`programme_id` )
    REFERENCES `webnaplo`.`Programme` (`idprogramme` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`Course_profile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Course_profile` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Course_profile` (
  `idcourse_profile` BIGINT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(128) NULL ,
  `course_id` BIGINT NOT NULL ,
  `staff_id` BIGINT NOT NULL ,
  `syllabus` LONGTEXT NULL ,
  PRIMARY KEY (`idcourse_profile`) ,
  INDEX `fk_cia_profile_staff1` (`staff_id` ASC) ,
  INDEX `fk_cia_profile_course1` (`course_id` ASC) ,
  CONSTRAINT `fk_cia_profile_staff1`
    FOREIGN KEY (`staff_id` )
    REFERENCES `webnaplo`.`Staff` (`idstaff` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cia_profile_course1`
    FOREIGN KEY (`course_id` )
    REFERENCES `webnaplo`.`Course` (`idcourse` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`cia_marks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`cia_marks` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`cia_marks` (
  `idcia_marks` BIGINT NOT NULL AUTO_INCREMENT ,
  `assignment` INT NULL ,
  `mark_1` INT NULL ,
  `mark_2` INT NULL ,
  `mark_3` INT NULL ,
  `cp_id` BIGINT NOT NULL ,
  `student_id` BIGINT NOT NULL ,
  PRIMARY KEY (`idcia_marks`) ,
  INDEX `fk_cia_marks_cia_profile1` (`cp_id` ASC) ,
  INDEX `fk_cia_marks_student1` (`student_id` ASC) ,
  CONSTRAINT `fk_cia_marks_cia_profile1`
    FOREIGN KEY (`cp_id` )
    REFERENCES `webnaplo`.`Course_profile` (`idcourse_profile` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cia_marks_student1`
    FOREIGN KEY (`student_id` )
    REFERENCES `webnaplo`.`Student` (`idstudent` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`Timetable`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Timetable` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Timetable` (
  `idtimetable` BIGINT NOT NULL AUTO_INCREMENT ,
  `days_of_week` INT NULL ,
  `hour_of_day` INT NULL ,
  `cp_id` BIGINT NOT NULL ,
  PRIMARY KEY (`idtimetable`) ,
  INDEX `fk_Timetable_Course_profile1` (`cp_id` ASC) ,
  CONSTRAINT `fk_Timetable_Course_profile1`
    FOREIGN KEY (`cp_id` )
    REFERENCES `webnaplo`.`Course_profile` (`idcourse_profile` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`Attendance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Attendance` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Attendance` (
  `idattendance` BIGINT NOT NULL AUTO_INCREMENT ,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `date` TIMESTAMP NULL ,
  `is_present` TINYINT NULL ,
  `student_id` BIGINT NOT NULL ,
  `timetable_id` BIGINT NOT NULL ,
  PRIMARY KEY (`idattendance`) ,
  INDEX `fk_attendance_student1` (`student_id` ASC) ,
  INDEX `fk_Attendance_Timetable1` (`timetable_id` ASC) ,
  CONSTRAINT `fk_attendance_student1`
    FOREIGN KEY (`student_id` )
    REFERENCES `webnaplo`.`Student` (`idstudent` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Attendance_Timetable1`
    FOREIGN KEY (`timetable_id` )
    REFERENCES `webnaplo`.`Timetable` (`idtimetable` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`Lock_Unlock`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`Lock_Unlock` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`Lock_Unlock` (
  `idlock_unlock` INT NOT NULL AUTO_INCREMENT ,
  `assignment` INT NULL ,
  `attendance` INT NULL ,
  `cia_1` INT NULL ,
  `cia_2` INT NULL ,
  `cia_3` INT NULL ,
  `cp_id` BIGINT NOT NULL ,
  PRIMARY KEY (`idlock_unlock`) ,
  INDEX `fk_Lock_Unlock_Course_profile1` (`cp_id` ASC) ,
  CONSTRAINT `fk_Lock_Unlock_Course_profile1`
    FOREIGN KEY (`cp_id` )
    REFERENCES `webnaplo`.`Course_profile` (`idcourse_profile` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`News`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`News` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`News` (
  `idNews` BIGINT NOT NULL AUTO_INCREMENT ,
  `news` TEXT NULL ,
  `date` TIMESTAMP NULL ,
  PRIMARY KEY (`idNews`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`configuration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`configuration` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`configuration` (
  `idconfiguration` INT NOT NULL AUTO_INCREMENT ,
  `key` VARCHAR(128) NULL ,
  `value` VARCHAR(1024) NULL ,
  PRIMARY KEY (`idconfiguration`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`ChangeDayOrder`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`ChangeDayOrder` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`ChangeDayOrder` (
  `idchangedayorder` BIGINT NOT NULL AUTO_INCREMENT ,
  `holiday_date` DATE NULL ,
  `compensation_date` DATE NULL ,
  `day_order` TINYINT NULL ,
  PRIMARY KEY (`idchangedayorder`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`cp_has_student`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`cp_has_student` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`cp_has_student` (
  `cp_id` BIGINT NOT NULL ,
  `idstudent` BIGINT NOT NULL ,
  PRIMARY KEY (`cp_id`, `idstudent`) ,
  INDEX `fk_Course_profile_has_Student_Student1` (`idstudent` ASC) ,
  INDEX `fk_Course_profile_has_Student_Course_profile1` (`cp_id` ASC) ,
  CONSTRAINT `fk_Course_profile_has_Student_Course_profile1`
    FOREIGN KEY (`cp_id` )
    REFERENCES `webnaplo`.`Course_profile` (`idcourse_profile` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Course_profile_has_Student_Student1`
    FOREIGN KEY (`idstudent` )
    REFERENCES `webnaplo`.`Student` (`idstudent` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webnaplo`.`attendance_ignore`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webnaplo`.`attendance_ignore` ;

CREATE  TABLE IF NOT EXISTS `webnaplo`.`attendance_ignore` (
  `idattendance_ignore` BIGINT NOT NULL AUTO_INCREMENT ,
  `date_attendance` DATE NULL ,
  `hour` TINYINT NULL ,
  `cp_id` BIGINT NOT NULL ,
  PRIMARY KEY (`idattendance_ignore`) ,
  INDEX `fk_attendance_ignore_Course_profile1` (`cp_id` ASC) ,
  CONSTRAINT `fk_attendance_ignore_Course_profile1`
    FOREIGN KEY (`cp_id` )
    REFERENCES `webnaplo`.`Course_profile` (`idcourse_profile` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Stores the date and hour when the period was ignored. These ' /* comment truncated */ ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `webnaplo`.`configuration`
-- -----------------------------------------------------
START TRANSACTION;
USE `webnaplo`;
INSERT INTO `webnaplo`.`configuration` (`idconfiguration`, `key`, `value`) VALUES (1, 'CONFIG_DATAENTRY_USER', 'dataentry');
INSERT INTO `webnaplo`.`configuration` (`idconfiguration`, `key`, `value`) VALUES (2, 'CONFIG_DATAENTRY_PASSWORD', 'dataentry');
INSERT INTO `webnaplo`.`configuration` (`idconfiguration`, `key`, `value`) VALUES (3, 'CONFIG_ADMIN_USER', 'webnaplo');
INSERT INTO `webnaplo`.`configuration` (`idconfiguration`, `key`, `value`) VALUES (4, 'CONFIG_ADMIN_PASSWORD	', 'webnaplo');
INSERT INTO `webnaplo`.`configuration` (`idconfiguration`, `key`, `value`) VALUES (5, 'CONFIG_SEM_START_DATE', '06/29/2011 00:00:00');
INSERT INTO `webnaplo`.`configuration` (`idconfiguration`, `key`, `value`) VALUES (6, 'CONFIG_DEFAULT_STAFF_PASSWORD', '$@$tr@');
INSERT INTO `webnaplo`.`configuration` (`idconfiguration`, `key`, `value`) VALUES (7, 'CONFIG_DEFAULT_STUDENT_PASSWORD', 'sastrasrc');

COMMIT;

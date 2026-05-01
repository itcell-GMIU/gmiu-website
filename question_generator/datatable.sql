CREATE TABLE `gmiu`.`tbl_weightage` ( `id` BIGINT(11) NOT NULL AUTO_INCREMENT , `subject_id` BIGINT(11) NOT NULL ,
 `chapter` VARCHAR(11) NOT NULL , `chapter_weight` BIGINT(11) NOT NULL , `create_at` TIMESTAMP NOT NULL , `update_at` TIMESTAMP NOT NULL , 
 `is_active` TINYINT(11) NOT NULL DEFAULT '1' , `is_delete` TINYINT(11) NOT NULL DEFAULT '0' ,
  `create_by` INT(11) NOT NULL , `delete_by` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;




  CREATE TABLE `gmiu`.`tbl_questions` 
  ( `id` BIGINT(11) NOT NULL AUTO_INCREMENT , `subject_code` VARCHAR(30) NOT NULL , 
  `chapter` INT(11) NOT NULL , `question` VARCHAR(255) NOT NULL , `marks` INT(11) NOT NULL ,
   `co_level` INT(11) NOT NULL , `bl_level` VARCHAR(30) NOT NULL , `create_at` TIMESTAMP NOT NULL ,
    `update_at` TIMESTAMP NOT NULL , `is_active` TINYINT(1) NOT NULL , `is_delete` TINYINT(0) NOT NULL , 
    `create_by` INT(11) NOT NULL , `delete_by` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;



    UPDATE `tbl_staff` SET `password`= 'gmiu@123?' WHERE role_id=4 and is_delete=0
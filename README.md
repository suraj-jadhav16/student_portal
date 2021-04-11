Please create a database and run the below queries, and update the database credentials in classes/database/Database.php:15 

CREATE TABLE `student` ( `id` INT NOT NULL AUTO_INCREMENT , `first_name` VARCHAR(255) NOT NULL , `last_name` VARCHAR(255) NOT NULL , `date_of_birth` DATE NOT NULL , `contact_number` INT(12) NOT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE `course` ( `id` INT NOT NULL AUTO_INCREMENT , `course_name` VARCHAR(255) NOT NULL , `course_details` TEXT NOT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE `subscribe_course` ( `id` INT NOT NULL AUTO_INCREMENT , `student_id` INT NOT NULL , `course_id` INT NOT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), FOREIGN KEY (`student_id`) REFERENCES `student`(`id`), FOREIGN KEY (`course_id`) REFERENCES `course`(`id`)) ENGINE = MyISAM;
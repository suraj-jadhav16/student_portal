<?php
/**
 * Created by PhpStorm.
 * User: Suraj Jadhav
 * Date: 10-04-2021
 * Time: 15:42
 */
require_once ('database/Database.php');
class Student{
    private $_connection = null;
    public static $perPage = 5;
    public function __construct(){
        $db = Database::getInstance();
        $this->_connection = $db->getConnection();
    }

    public function insertStudent($student){
        $first_name = $this->validateString($student['first_name']);
        $last_name = $this->validateString($student['last_name']);
        $date_of_birth = $this->validateString($student['date_of_birth']);
        $contact_number = (int) $student['contact_number'];

        $sql = "INSERT INTO `student` SET 
            `id` = NULL, 
            `first_name` = '".$first_name."',
            `last_name` = '".$last_name."',
            `date_of_birth` = '".$date_of_birth."', 
            `contact_number` = '".$contact_number."', 
            `created_at` = CURRENT_TIMESTAMP";

        $result = $this->_connection->query($sql);
        if (!$result) {
            throw new Exception(mysqli_error($this->_connection));
        }

        return json_encode($this->_connection->insert_id);
    }

    private function validateString($string){
        return (string) preg_replace('/<script\b[^>]*>(.*?)<\/script>/', "", htmlspecialchars(strip_tags($string), ENT_QUOTES, 'UTF-8'));
    }

    public function getTotal($table_name){
        $result = $this->_connection->query("SELECT id FROM `{$table_name}`");
        if (!$result) {
            throw new Exception(mysqli_error($this->_connection));
        }
        return $result->num_rows;
    }

    public function getStudents($page, $all = false){
        $limit = '';
        if(!$all) {
            $begin = ($page == '') ? 0 : ($page * self::$perPage);
            $limit = " limit " . $begin . ", " . self::$perPage;
        }
        $result = $this->_connection->query("SELECT `id`,`first_name`,`last_name` FROM `student` ORDER BY `id` DESC {$limit}");
        return $result;
    }

    public function deleteStudent($id){
        $this->_connection->query("DELETE FROM `student` WHERE `id` = {$id}");
        $this->_connection->query("DELETE FROM `subscribe_course` WHERE `student_id` = {$id}");
    }

    public function getStudentById($id){
        $result = $this->_connection->query("SELECT * FROM `student` where `id`={$id}");
        return $result;
    }

    public function updateStudent($student){
        $first_name = $this->validateString($student['first_name']);
        $last_name = $this->validateString($student['last_name']);
        $date_of_birth = $this->validateString($student['date_of_birth']);
        $contact_number = (int) $student['contact_number'];

        $sql = "UPDATE `student` SET  
            `first_name` = '".$first_name."',
            `last_name` = '".$last_name."',
            `date_of_birth` = '".$date_of_birth."', 
            `contact_number` = '".$contact_number."'
            WHERE id={$student['insert_student']}";

        $this->_connection->query($sql);
        return json_encode($student['insert_student']);
    }

    public function subscribeCourse($subscribe_course){
        $result = $this->_connection->query("SELECT id FROM `subscribe_course` WHERE `student_id`={$subscribe_course['student_id']} AND `course_id`={$subscribe_course['course_id']}");
        if (!$result) {
            throw new Exception(mysqli_error($this->_connection));
        }
        if($result->num_rows > 0){
            return json_encode(array('error' => 1, 'message' => 'Student is already subscribed to this course. Please select other course.'));
        }

        $sql = "INSERT INTO `subscribe_course` SET 
            `id` = NULL, 
            `student_id` = '".(int) $subscribe_course['student_id']."',
            `course_id` = '".(int) $subscribe_course['course_id']."', 
            `created_at` = CURRENT_TIMESTAMP";

        $result = $this->_connection->query($sql);
        if (!$result) {
            throw new Exception(mysqli_error($this->_connection));
        }

        return json_encode(array('error' => 0, 'message' => 'Subscribed successfully.'));
    }

    public function getSubscribedCourses($page, $all = false){
        $limit = '';
        if(!$all) {
            $begin = ($page == '') ? 0 : ($page * self::$perPage);
            $limit = " limit " . $begin . ", " . self::$perPage;
        }
        $result = $this->_connection->query("SELECT `sub_c`.`id`,CONCAT(`stud`.`first_name`,' ',`stud`.`last_name`) as `full_name`, `cou`.`course_name` FROM `student` as `stud` 
                JOIN `subscribe_course` as `sub_c` ON `stud`.`id`=`sub_c`.`student_id` 
                JOIN `course` as `cou` ON `cou`.`id`=`sub_c`.`course_id` ORDER BY `sub_c`.`id` DESC {$limit}");
        return $result;
    }
}
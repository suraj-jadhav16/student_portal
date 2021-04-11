<?php
/**
 * Created by PhpStorm.
 * User: Suraj Jadhav
 * Date: 10-04-2021
 * Time: 21:46
 */

require_once ('database/Database.php');
class Course{
    private $_connection = null;
    public static $perPage = 5;
    public function __construct(){
        $db = Database::getInstance();
        $this->_connection = $db->getConnection();
    }

    public function insertCourse($course){
        $course_name = $this->validateString($course['course_name']);
        $course_details = $this->validateString($course['course_details']);

        $sql = "INSERT INTO `course` SET 
            `id` = NULL, 
            `course_name` = '".$course_name."',
            `course_details` = '".$course_details."',
            `created_at` = CURRENT_TIMESTAMP";

        $result = $this->_connection->query($sql);
        if (!$result) {
            throw new Exception(mysqli_error($this->_connection));
        }

        error_log($this->_connection->insert_id);
        return json_encode($this->_connection->insert_id);
    }

    private function validateString($string){
        return (string) preg_replace('/<script\b[^>]*>(.*?)<\/script>/', "", htmlspecialchars(strip_tags($string), ENT_QUOTES, 'UTF-8'));
    }

    public function getTotalCourses(){
        $result = $this->_connection->query("SELECT id FROM `course`");
        if (!$result) {
            throw new Exception(mysqli_error($this->_connection));
        }
        return $result->num_rows;
    }

    public function getCourses($page, $all = false){
        $limit = '';
        if(!$all) {
            $begin = ($page == '') ? 0 : ($page * self::$perPage);
            $limit = " limit " . $begin . ", " . self::$perPage;
        }
        $result = $this->_connection->query("SELECT `id`,`course_name`,`course_details` FROM `course` ORDER BY `id` DESC {$limit}");
        return $result;
    }

    public function deleteCourse($id){
        $this->_connection->query("DELETE FROM `course` WHERE `id` = {$id}");
        $this->_connection->query("DELETE FROM `subscribe_course` WHERE `course_id` = {$id}");
    }

    public function getCourseById($id){
        $result = $this->_connection->query("SELECT * FROM `course` where `id`={$id}");
        return $result;
    }

    public function updateCourse($course){
        $course_name = $this->validateString($course['course_name']);
        $course_details = $this->validateString($course['course_details']);

        $sql = "UPDATE `course` SET  
            `course_name` = '".$course_name."',
            `course_details` = '".$course_details."'
            WHERE id={$course['insert_course']}";

        $this->_connection->query($sql);
        return json_encode($course['insert_course']);
    }
}
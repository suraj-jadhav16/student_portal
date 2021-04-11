<?php
require_once ('../classes/Student.php');
require_once ('../classes/Course.php');

if(isset($_POST['insert_student']) && $_POST['insert_student'] == 1 ){
    echo (new Student())->insertStudent($_POST);
}

if(isset($_POST['insert_student']) && $_POST['insert_student'] > 0){
    echo (new Student())->updateStudent($_POST);
}

if(isset($_POST['insert_course']) && $_POST['insert_course'] == 1){
    echo (new Course())->insertCourse($_POST);
}

if(isset($_POST['insert_course']) && $_POST['insert_course'] > 0){
    echo (new Course())->updateCourse($_POST);
}

if(isset($_POST['subscribe_course']) && $_POST['subscribe_course'] == 1){
    echo (new Student())->subscribeCourse($_POST);
}
<?php
require_once ('../classes/Student.php');
require_once ('../classes/Course.php');
$courses = (new Course())->getCourses(0, true);
$students = (new Student())->getStudents(0, true);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <link href="../bootstrap/dist/css/navbar-top-fixed.css" rel="stylesheet">
    <link rel="stylesheet" href="../jquery/jquery-ui.min.css">
    <script src="../jquery/external/jquery/jquery.js"></script>
    <script src="../jquery/jquery-ui.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
</head>
<body>
<?php include_once('../layouts/header.php') ?>
<main role="main" class="container" >
    <div class="my-3 p-3 bg-white rounded box-shadow ">
        <h6 class="border-bottom border-gray pb-2 mb-0">Student Course Registration</h6>
        <div class="container md-6" style="margin: auto;width: 50%;padding: 10px;">
            <form id="frm" method="post">
                <div class="mb-3 row">
                    <label for="first_name" class="col-sm-2 col-form-label">Student</label>
                    <div class="col-sm-4">
                        <select name="student_id" id="student_id" class="form-select" aria-label="Default select example">
                            <?php while ($student = $students->fetch_array()){ ?>
                                <option value="<?= $student['id'] ?>"><?= $student['first_name'] . ' ' . $student['last_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label for="first_name" class="col-sm-2 col-form-label">Course</label>
                    <div class="col-sm-4">
                        <select name="course_id" id="course_id" class="form-select" aria-label="Default select example">
                            <?php while ($course = $courses->fetch_array()){ ?>
                                <option value="<?= $course['id'] ?>"><?= $course['course_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-10" style="display: flex;justify-content: center;">
                        <input type="button" value="<?= isset($_GET['edit'])  ? 'Update' : 'Submit' ?>" id="submit_form">
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#submit_form').click(function () {
            let student_id = document.getElementById("student_id").value.trim();
            let course_id = document.getElementById("course_id").value.trim();
            let alert_message = [];
            if(student_id.length === 0){
                alert_message.push('First name can\'t be empty.');
            }
            if(course_id.length === 0){
                alert_message.push('Last name can\'t be empty.');
            }
            if(alert_message.length > 0) {
                alert(alert_message.join('\n'));
            }else {
                submitAjax();
            }
        });

        function submitAjax() {
            $("#frm").ajaxSubmit({
                url: '../route/ajax.php',
                method: 'POST',
                dataType: 'JSON',
                data:{
                    subscribe_course : 1
                },
                success: (response) => {
                    alert(response.message);
                }
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>

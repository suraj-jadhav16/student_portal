<?php
require_once ('../classes/Course.php');
if(isset($_GET['edit'])){
    $course_obj = new Course();
    $courses = $course_obj->getCourseById((int) $_GET['edit']);
    $course = $courses->fetch_array();
}
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
        <h6 class="border-bottom border-gray pb-2 mb-0">Course Details</h6>
        <div class="container md-6" style="margin: auto;width: 50%;padding: 10px;">
            <form id="frm" method="post">
                <div class="mb-3 row">
                    <label for="course_name" class="col-sm-2 col-form-label">Course Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="course_name" id="course_name" value="<?= isset($_GET['edit']) ? $course['course_name'] : '' ?>" >
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="course_details" class="col-sm-2 col-form-label">Course Details</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="course_details" name="course_details" rows="3"><?= isset($_GET['edit']) ? $course['course_details'] : '' ?></textarea>
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
            let course_name = document.getElementById("course_name").value.trim();
            let course_details = document.getElementById("course_details").value.trim();
            let alert_message = [];
            if(course_name.length === 0){
                alert_message.push('Course name can\'t be empty.');
            }
            if(course_details.length === 0){
                alert_message.push('Course details can\'t be empty.');
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
                    insert_course : '<?= isset($_GET['edit'])  ? $_GET['edit'] : 1 ?>'
                },
                success: (response) => {
                    console.log(response);
                    if(parseInt(response) > 0){
                        window.location.href = 'course_list.php';
                    }
                }
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>

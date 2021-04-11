<?php
require_once ('../classes/Student.php');
if(isset($_GET['edit'])){
    $student_obj = new Student();
    $students = $student_obj->getStudentById((int) $_GET['edit']);
    $student = $students->fetch_array();
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
        <h6 class="border-bottom border-gray pb-2 mb-0">Student Details</h6>
        <div class="container md-6" style="margin: auto;width: 50%;padding: 10px;">
            <form id="frm" method="post">
                <div class="mb-3 row">
                    <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?= isset($_GET['edit']) ? $student['first_name'] : '' ?>" >
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="last_name" id="last_name" value="<?= isset($_GET['edit']) ? $student['last_name'] : ''?>"/>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="date_of_birth" class="col-sm-2 col-form-label">DOB</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="<?= isset($_GET['edit']) ? $student['date_of_birth'] : '' ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="contact_number" class="col-sm-2 col-form-label">Contact No</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="contact_number" id="contact_number" onkeydown="return isNumberKey($(this))"
                               value="<?= isset($_GET['edit']) ? $student['contact_number'] : ''?>"" />
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

function on_key_down(obj) {
    var code;
    var e = window.event; // some browsers don't pass e, so get it from the window
    if (e.keyCode) code = e.keyCode; // some browsers use e.keyCode
    else if (e.which) code = e.which;  // others use e.which
    if (code == 8 || code == 46){ // Backspace and delete button
        $.datepicker._clearDate(obj);
    }
    e.preventDefault();
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105)) {
        return false;
    }
    return true;
}

$(document).ready(function() {
    $("#date_of_birth").datepicker({
        dateFormat : 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });

    $('#submit_form').click(function () {
        let first_name = document.getElementById("first_name").value.trim();
        let last_name = document.getElementById("last_name").value.trim();
        let date_of_birth = document.getElementById("date_of_birth").value.trim();
        let contact_number = document.getElementById("contact_number").value.trim();
        let alert_message = [];
        if(first_name.length === 0){
            alert_message.push('First name can\'t be empty.');
        }
        if(last_name.length === 0){
            alert_message.push('Last name can\'t be empty.');
        }
        if(date_of_birth.length === 0){
            alert_message.push('Date of birth can\'t be empty.');
        }
        if(contact_number.length === 0){
            alert_message.push('Contact number can\'t be empty.');
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
                insert_student : '<?= isset($_GET['edit'])  ? $_GET['edit'] : 1 ?>'
            },
            success: (response) => {
                if(parseInt(response) > 0){
                    window.location.href = 'student_list.php';
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

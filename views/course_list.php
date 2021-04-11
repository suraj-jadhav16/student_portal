<?php
require_once ('../classes/Course.php');
$course_obj = new Course();

if(isset($_GET['delete'])){
    $course_obj->deleteCourse((int) $_GET['delete']);
}

$page = 0;
if(isset($_GET['page'])){
    $page = (int) $_GET['page'];
}
$courses = $course_obj->getCourses($page);
$pagination = ceil($course_obj->getTotalCourses() / Course::$perPage);
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
        <h6 class="border-bottom border-gray pb-2 mb-0">Course List</h6>
        <div class="container md-6" style="margin: auto;width: 50%;padding: 10px;">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Options</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($course = $courses->fetch_array()){ ?>
                    <tr>
                        <td><?= $course['course_name'] ?></td>
                        <td><?= $course['course_details'] ?></td>
                        <td>
                            <a class="ui-icon-link" href="course.php?edit=<?= $course['id'] ?>">Edit</a>
                            <a class="ui-icon-link" href="?delete=<?= $course['id'] ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for($page_number = 1 ; $page_number <= $pagination ; $page_number++){ ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page_number - 1 ?>"><?= $page_number ?></a></li>
                    <? } ?>
                </ul>
            </nav>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>

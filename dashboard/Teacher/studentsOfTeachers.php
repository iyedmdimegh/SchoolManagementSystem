<?php
session_start();
require_once('../../form/verifyAdmin.php');
require_once('../../database/dbcreation.php');
verifyTeacher();
$pdo = ConnexionBD::getInstance();
$teacherInfo=ConnexionBD::getUserInfo('teacher');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">Teacher's Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../main.css" rel="stylesheet">
    <link href="../nav%20bar.css" rel="stylesheet">

</head>
<body>
<nav class="navbar">
    <div class="container-nav">
        <div class="logo-uni-nav">
            <a class="ucar" href="#"><img src="../src/logo-ucar.png"></a>
            <a class="insat" href="#"><img src="../src/logo-insat.png"></a>
            <h3 class="page-title">Teacher's Space</h3>

        </div>
        <div class="profile-nav" >
            <p class="username-nav">Welcome, <?=$teacherInfo['firstname']." ".$teacherInfo['lastname'] ?>  </p>
            <img class="profile-pic-nav" src="../src/profile%20pic.png">
            <button class="btn btn-deconnect" type="submit" onclick="window.location.href = '../../form/form.php';">Log Out</button>
        </div>

    </div>
</nav>
<main>
    <!-- vertical nav bar -->
    <nav class="main-menu">
        <h1 class="current-nav-element">Menu</h1>
        <img class="logo" src="../src/logo.png" alt="logo" />
        <ul>
            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="dashboardTeacher.php">
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="scheduleTeacher.php">
                    <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Schedule</span>
                </a>
            </li>

            <li class="nav-item-vertical active">
                <b></b>
                <b></b>
                <a href="#">
                    <!-- <img src="src/abscent white.png" alt="abscence img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Students</span>
                </a>
            </li>

            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="#">
                    <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Std Absences</span>
                </a>
            </li>
        </ul>
    </nav>



    <section class="content">

        <!-- Show More Modal -->
        <div class="modal fade" id="showMoreModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Additional Information:</h5>
                    </div>
                    <div class="modal-body" id="studentInfo">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mark Absence Modal -->
        <div class="modal fade" id="markAbsenceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mark Absence:</h5>
                    </div>
                    <div class="modal-body mark-absence">
                        <form action="markAbsence.php" method="post">
                            <div class="form-group row">
                                <label for="studentID" class="col-sm-2 col-form-label">Student ID:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="studentID" name="studentID" required readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="courseID" class="col-sm-2 col-form-label">Course ID: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="courseID" name="courseID" required readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="absenceDate" class="col-sm-2 col-form-label">Date:</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="absenceDate" name="absenceDate" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="absenceReason" class="col-sm-2 col-form-label">Reason:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="absenceReason" name="absenceReason" required>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" name="markAbsence">Mark Absence</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- content of profile section  -->
        <div class="container">
            <div class="row">
                <div class="row title">
                    <div class="col-9 student-name-container">
                        <h2 class="student-name">My Students </h2>
                    </div>
                </div>
                <?php
                $students = ConnexionBD::getStudentsByTeacher($teacherInfo['id']);
                ?>
                <script>
                    const students = <?= json_encode($students) ?>;
                    console.log(students);
                </script>
                <div class="card-container">
                    <div class="card">
                        <?php
                        $students = ConnexionBD::getStudentsByTeacher($teacherInfo['id']);
                        if ($students == null) { ?>
                            <p>You have no Students.</p>
                        <?php } else { ?>

                        <div class="row info filter">
                            <!-- Filter form -->
                            <form action="studentsOfTeachers.php" method="post">
                                <div class="col">
                                    <p>Filter students by Course: <br>
                                            <select name="filterCourseFieldLevel" id="filterCourseFieldLevel">
                                                <option value="default">--</option>
                                                <!-- Populate this with the courses the teacher teaches -->

                                                <?php
                                                $courses = ConnexionBD::getCoursesOfTeacher($teacherInfo['id']);?>
                                                <?php foreach ($courses as $course) {

                                                    $courseDetail = $course->coursename.'-'.$course->field.'-'.$course->studylevel;
                                                    ?>
                                                <option value= "<?=$courseDetail?>"> <?=$courseDetail?> </option>
                                                <?php }
                                                ?>
                                            </select>
                                    </p>
                                    <script>
                                        const courses = <?= json_encode($courses) ?>;
                                        console.log(courses);
                                    </script>
                                </div>
                                <div class="col-8">
                                    <button hidden class="btn btn-outline" id="cancel" >Cancel Filter</button>
                                </div>

                            </form>
                            <!-- Students table -->
                            <div class="card card-two">
                                <div class="row info tbl">
                                    <!-- bootstrap table -->
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Field</th>
                                                <th scope="col">Level</th>
                                                <th scope="col">Enrolled Course</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body">
                                        <!-- The student list that will be loaded-->
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-primary" id="loadMore">Load More</button>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of profile section -->
    </section>
</main>
<script src="../script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
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
    <title>Teacher's Space</title>
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
            <li class="nav-item-vertical active">
                <b></b>
                <b></b>
                <a href="dashboardTeacher.php">
                    <img src="../src/profile%20pic.png" alt="home img " class="nav-vertical-icons">
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

            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="studentsOfTeachers.php">
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

        <!-- content of profile section  -->
        <div class="container">
            <div class="row">
                <div class="row title">
                    <div class="col pfp">
                        <img src="../src/profile%20pic.png" alt="Profile Pic" class="pfp" />
                    </div>
                    <div class="col-9 student-name-container">
                        <h2 class="student-name"><?=$teacherInfo['firstname']." ".$teacherInfo['lastname'] ?></h2>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <div class="row info">
                            <div class="col">
                                <p>ID Number:</p>
                                <p>Institutional Email: </p>
                                <p>Phone:</p>
                                <p>Gender:</p>
                            </div>
                            <div class="col-9">
                                <p><?= $teacherInfo['id'] ?></p>
                                <p><?= $teacherInfo['email'] ?></p>
                                <p><?= $teacherInfo['phone'] ?></p>
                                <p><?= $teacherInfo['gender'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of profile section -->
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
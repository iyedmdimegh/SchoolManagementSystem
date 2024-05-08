<?php
  session_start();
  require_once('../../form/verifyAdmin.php');
  require_once('../../database/dbcreation.php');
  verifyStudent();
  $studentInfo=ConnexionBD::getUserInfo('student');
  $_SESSION['field']=$studentInfo['field'];
  $_SESSION['studylevel']=$studentInfo['studylevel'];
  $_SESSION['studentID']=$studentInfo['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student's Space</title>
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
            <h3 class="page-title">Student's Space</h3>

        </div>
        <div class="profile-nav" >
          <p class="username-nav">Welcome, <?=$studentInfo['firstname']." ".$studentInfo['lastname'] ?>  </p>
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
            <a href="#">
              <img src="../src/profile%20pic.png" alt="home img " class="nav-vertical-icons">
              <span class="nav-text">Profile</span>
            </a>
          </li>
          <li class="nav-item-vertical">
            <b></b>
            <b></b>
            <a href="scheduleStudent.php">
              <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
              <span class="nav-text">Schedule</span>
            </a>
          </li>

          <li class="nav-item-vertical">
            <b></b>
            <b></b>
            <a href="absencesEtudiant.php">
              <!-- <img src="src/abscent white.png" alt="abscence img " class="nav-vertical-icons"> -->
              <span class="nav-text">Absences</span>
            </a>
          </li>

          <li class="nav-item-vertical">
            <b></b>
            <b></b>
            <a href="videoCourses.php">
              <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
              <span class="nav-text">Courses</span>
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
              <h2 class="student-name"><?=$studentInfo['firstname']." ".$studentInfo['lastname'] ?></h2>
            </div>
          </div>
          <div class="card-container">
            <div class="card">
              <div class="row info">
                <div class="col">
                    <p>ID Number:</p>
                    <p>Institutional Email: </p>
                    <p>Field:</p>
                    <p>Study Level:</p>
                    <p>Class:</p>
                </div>
                <div class="col-9">
                    <p><?= $studentInfo['id'] ?></p>
                    <p><?= $studentInfo['email'] ?></p>
                    <p><?= $studentInfo['field'] ?></p>
                    <p><?= ($studentInfo['studylevel']=='1')? $studentInfo['studylevel']."st" : $studentInfo['studylevel']."nd" ?> Year</p>
                    <p><?= $studentInfo['class'] ?></p>
                </div>
              </div>
            </div>
            <div class="card card-two">
              <div class="row info">
                <div class="col">
                    <p>Birthdate: </p>
                    <p>Address: </p>
                    <p>Nationality: </p>
                    <p>Gender: </p>
                </div>
                <div class="col-9">
                    <p><?= $studentInfo['birthdate'] ?></p>
                    <p><?= $studentInfo['address'] ?></p>
                    <p><?= $studentInfo['nationality'] ?></p>
                    <p><?= $studentInfo['gender'] ?></p>
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
<?php
  session_start();
  require_once('../../database/dbcreation.php');
  require_once('../../form/verifyAdmin.php');
  verifyStudent();
  $pdo = ConnexionBD::getInstance();
  $studentInfo=ConnexionBD::getUserInfo('student');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student's Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../main.css" rel="stylesheet">
    <link href="../nav bar.css" rel="stylesheet">
    <link href="../absences.css" rel="stylesheet">

</head>
  <body>
    <nav class="navbar">
      <div class="container-nav">
        <div class="logo-uni-nav">
            <a class="ucar" href="#"><img src="../src/logo-ucar.png"></a>
            <a class="insat" href="#"><img src="../src/logo-insat.png"></a>
            <h3 class="page-title">Student's Space</h3>

        </div>
        <button class="btn btn-deconnect mobile" type="submit">Log Out</button>
        <div class="profile-nav" >
          <p class="username-nav">Welcome, <?=$studentInfo['firstname']." ".$studentInfo['lastname'] ?></p>
          <img class="profile-pic-nav" src="../src/profile%20pic.png">
          <button class="btn btn-deconnect" type="submit" onclick="window.location.href = '../../form/form.php';">Se Déconnecter</button>
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
            <a href="dashboardEtudiant.php">
              <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
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

          <li class="nav-item-vertical active">
            <b></b>
            <b></b>
            <a href="#">
              <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
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

        <!-- profile section -->
      <section class="container">
          <div class="row title">
              <div class="col-9 student-name-container">
                  <h2 class="student-name">Absences</h2>
              </div>
          </div>
            <div class="absences-list">
                <div class="container text-center list-header">
                    <div>Course</div>
                    <div>Number of Absences</div>
                </div>
                <hr>
                <ul class="absences-list-inner">
                    <?php
                    //preparing and binding statement
                    $stmt = $pdo->prepare("SELECT * , count(absencedate) as nombre_absences FROM absence,course WHERE absence.student = :id AND course.id = absence.course
                                    group by(course)");
                    $stmt->bindParam(':id',$_SESSION['user_id'], type: PDO::PARAM_INT);
                    $stmt->execute();
                    $absences = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($absences as $absence) {?>

                        <li >
                            <ul class="abscence-item">
                                <li ><?= $absence['coursename']?></li>
                                <li ><?=$absence['nombre_absences']?></li>
                            </ul>
                        </li>

                        <?php
                    }

                    ?>

                </ul>
            </div>

        
        
      <!-- end of profile section -->
    </section>
    </main>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
  </body>



</html> 
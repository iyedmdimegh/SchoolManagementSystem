<?php
session_start();
require_once('../../form/verifyAdmin.php');
require_once('../../database/dbcreation.php');
verifyTeacher();
$pdo = ConnexionBD::getInstance();
$teacherInfo=ConnexionBD::getUserInfo('teacher');
$Schedule=ConnexionBD::getScheduleTeacher();
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
    <link rel="stylesheet" href="../schedule.css">

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
            <li class="nav-item-vertical active">
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
        <div id='calendar' class="calendar"></div>  
    </section>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
      let schedule = <?= json_encode($Schedule); ?>;
      console.log(schedule);
      console.log(schedule[0]['day_of_week']);

      let events = [];
        let colors=['#6e2020','#165a16','#0000FF','#17176e','#54b5b5','#9b489b'];
        let bindColor={};
      schedule.forEach(function(item) {
        let start_task = item['start_date']+'T'+item['start_time'];
        let end_task = item['start_date']+'T'+item['end_time'];
        if(!bindColor[item['description']]){
            bindColor[item['description']]=colors.pop();
        }
        let event = {
          title: item['description'], // Description
          start: start_task, // Start time
          end: end_task, // End time
          color: bindColor[item['description']] // Color (you can customize this from the list of available colors)
        };

        events.push(event);
      });


      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'timeGridWeek',
          allDaySlot: false,
          slotMinTime: '08:00:00',
          slotMaxTime: '22:00:00',
          hiddenDays: [0],
          events: events // Pass the events array here
        });
        calendar.render();
      });
</script>

</main>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
</body>
</html>
















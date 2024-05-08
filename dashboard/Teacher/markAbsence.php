<?php
session_start();
require_once('../../database/dbcreation.php');
$pdo = ConnexionBD::getInstance();

//marks absence of a student
if (isset($_POST['markAbsence'])) {
    $studentID = $_POST['studentID'];
    $courseID = $_POST['courseID'];
    $date = $_POST['absenceDate'];
    $teacherID = $_SESSION['id'];
    $stmt = $pdo->prepare('INSERT INTO absence (student, course, absencedate) VALUES (:student, :course, :absencedate)');
    $stmt->bindParam(':student', $studentID);
    $stmt->bindParam(':course', $courseID);
    $stmt->bindParam(':absencedate', $date);
    $stmt->execute();

    //redirect to studentsOfTeachers.php
    header('Location: studentsOfTeachers.php');
}

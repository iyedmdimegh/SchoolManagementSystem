<?php

require_once('../database/dbcreation.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get the data from the form
    $data = [
        'firstname' => $_POST['firstName'],
        'lastname' => $_POST['lastName'],
        'email' => $_POST['email'],
        'phone' => intval($_POST['phone']),
        'address' => $_POST['address'],
        'birthdate' => $_POST['birthDate'],
        'gender' => $_POST['gender'],
        'nationality' => $_POST['nationality'],
        'education' => $_POST['education'],
        'program' => $_POST['program'],
        'achievements' => $_POST['achievements'],
        'essay' => $_POST['essay']
    ];

    // add the submission to the database
    ConnexionBD::add_submission($data);

    //redirect to index
    header("Location: ../index.php");
}
?>
<?php
//function to verify if the user is an admin
function verifyAdmin() : void
{
    // Start the session if it's not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $_SESSION['isGuest']=true;
    }

    // Check if the user is logged in and is an admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
        // If not, display alert and redirect them to the login page
        $message="You are not authorized to access this page";
        echo "<script type='text/javascript'>
        alert('$message');
        setTimeout(function(){
            window.location.href = '/form/form.php';
        }, 1000);
        </script>";
        exit;
    }
}
//function to verify if the user is a teacher
function verifyTeacher(): void
{
    // Start the session if it's not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $_SESSION['isGuest']=true;
    }

    // Check if the user is logged in and is an admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'teacher') {
        // If not, display alert and redirect them to the login page
        $message="You are not authorized to access this page";
        echo "<script type='text/javascript'>
        alert('$message');
        setTimeout(function(){
            window.location.href = '/form/form.php';
        }, 1000);
        </script>";
        exit;
    }
}
//function to verify if the user is a student
function verifyStudent(): void
{
    // Start the session if it's not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $_SESSION['isGuest']=true;
    }

    // Check if the user is logged in and is an admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
        // If not, display alert and redirect them to the login page
        $message="You are not authorized to access this page";
        echo "<script type='text/javascript'>
        alert('$message');
        setTimeout(function(){
            window.location.href = '/form/form.php';
        }, 1000);
        </script>";
        exit;
    }

}
//function to log out
function logOut(){
    // Start the session if it's not already started
    session_start();
    // Unset all session values
    session_destroy();
    //redirect to the login page
    header("Location: /form/form.php");
    exit;
}

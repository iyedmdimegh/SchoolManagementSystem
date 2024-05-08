
<?php

session_start();
// Include the dbcreation.php file
require_once('../database/dbcreation.php');

// Get an instance of the PDO connection
$pdo = ConnexionBD::getInstance();

if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    // Check if the email and password match some predefined values (for demonstration purposes)
    $email = $_POST['email'];
    $password = $_POST['password'];
    try {
        // Using prepared statements to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM user_auth WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();


        if ($user && password_verify($password, $user['password'])) {
            // Authentication successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_type'] = $user['type'];
            $_SESSION['isGuest'] = false;

            echo "User authenticated successfully";

            // Redirect to the corresponding dashboard
            switch($user['type']) {
                case 'admin':
                    header("Location: ../dashboard/Admin/dashboardAdmin.php");
                    break;
                case 'teacher':
                    header("Location: ../dashboard/Teacher/dashboardTeacher.php");
                    break;
                case 'student':
                    header("Location: ../dashboard/Student/dashboardEtudiant.php");
                    break;
            }
            exit;
        } else {
            // Invalid email or password
            $_SESSION['error'] = "Invalid email or password";
            header("Location: form.php");
            exit;
        }
    }
    catch (PDOException $e) {
        // Handle database errors
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header("Location: form.php");
        exit;
    }
} else {
    // Handle case when email or password is not provided
    $_SESSION['error'] = "Email and password are required.";
    header("Location: form.php");
    exit;
}

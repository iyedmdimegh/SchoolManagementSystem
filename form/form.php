<?php
    session_start();
    session_destroy();
    $_SESSION['isGuest'] = true;
    require_once('../form/verifyAdmin.php');
    // create the database if not exists and fill it with data
    $running_form = true;
    require_once('../database/dbcreation.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="form.css" rel="stylesheet">
</head>
<body>
    <img src="../Landing%20Page/src/logo-insat.png" alt="logo lfac" class="logo-fac">
    <h1>Good to see you again !</h1>

    <form id="msform" action="processForm.php" method="post">
        <fieldset>
            <h2 class="fs-title">Log in</h2>
            <label for="email" class="form-label">Email:</label>
            <input type="text" name="email" placeholder="demo@insat.com" id="email" name="email"/>
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" placeholder="demo1234" name="password"/>
            
            <!-- Display error message if exist -->
            <?php
                if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                    echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
                    // Clear the error atr from session
                    unset($_SESSION['error']);
                }
            ?>
            
            <input type="submit" name="next" class="next action-button" value="Sign in" />
        </fieldset>
    </form>
</body>
</html>

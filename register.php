<?php
require "vendor/autoload.php";

session_start();

// 2. Why do you think the session variable assignments are wrapped inside an if-else and try-catch statements?

/* Session variable assignments are wrapped inside if-else and try-catch lines to 
   ensure that the session variable is assigned a value before it is used. 
   If the session variable is not assigned a value before it is used, it will throw an exception. */

try {
    if (isset($_POST['complete_name']) && isset($_POST['email']) && isset($_POST['birthdate'])) {
        $_SESSION['user_completename'] = $_POST['complete_name'];
        $_SESSION['user_email'] = $_POST['email'];
        $_SESSION['user_birthdate'] = $_POST['birthdate'];

        header('Location: quiz.php');
        exit;
    } else {
        throw new Exception('There is a missing basic information.');
    }
} catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
}
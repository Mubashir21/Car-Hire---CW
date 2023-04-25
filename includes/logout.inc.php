<?php 

    // destroys the session and logs the user out

    session_start();
    session_unset();
    session_destroy();
    header("Location: ../html/login.php");

?>
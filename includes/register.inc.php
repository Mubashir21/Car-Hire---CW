<?php

if (isset($_POST['register-button'])) {
    
    require 'dbh.inc.php';

    // gets information from user
    $username = strtolower($_POST['username']);
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];
    $passwordrepeat = $_POST['passwordrepeat'];

    // checks for invalid form entries
    if (empty($username) || empty($email) || empty($password) || empty($passwordrepeat)) {
        header("Location: ../html/register.php?error=emptyfields&username=".$username."&email=".$email);
        exit();
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../html/register.php?error=invalidemailusername");
        exit();
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../html/register.php?error=invalidemail&username=".$username);
        exit();
    }
    elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../html/register.php?error=invalideusername&email=".$email);
        exit();
    }
    elseif ($password !== $passwordrepeat) {
        header("Location: ../html/register.php?error=passwordcheck&username=".$username."&email=".$email);
        exit();
    }
    else {
        // checks whether username is taken
        $sql = "SELECT username FROM staff WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../html/register.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resutcheck = mysqli_stmt_num_rows($stmt);
            if ($resutcheck > 0) {
                header("Location: ../html/register.php?error=usertaken&email=".$email);
                exit();
            }
            else {
                $sql = "INSERT INTO staff (username, email, pwd) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../html/register.php?error=sqlerror");
                    exit();
                }
                else {
                    // hashes the password, and stores the new user information in database
                    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedpassword);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../html/login.php?register=success");
                    exit();
                }
            }
        }
    }
}
else {
    header("Location: ../html/register.php");
    exit();
}
  
?>
<?php 

    // check username and password against the database, and lets the user in if the credentials are correct

    if (isset($_POST["login-button"])) {
        
        require 'dbh.inc.php';

        $emailuid = strtolower($_POST["emailuid"]);
        $password = $_POST["password"];

        if (empty($emailuid) || empty($password)) {
            header("Location: ../html/login.php?error=emptyfields");
            exit();
        }
        else {

            $sql = "SELECT * FROM staff WHERE username=? OR email=?;";
            $stmt = mysqli_stmt_init($conn);  
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../html/login.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $emailuid, $emailuid);
                mysqli_stmt_execute($stmt); 
                $result = mysqli_stmt_get_result($stmt);

                if ($row = mysqli_fetch_assoc($result)) {
                    $pwdcheck = password_verify($password, $row["pwd"]);
                    if ($pwdcheck == false) {
                        header("Location: ../html/login.php?error=wrongpwd");
                        exit();
                    }
                    elseif ($pwdcheck == true) {
                        session_start();
                        $_SESSION['userId'] = $row['staff_id'];
                        $_SESSION['userName'] = $row['username'];
                        header("Location: ../html/booking.php?login=success");
                        exit();
                    }
                    else {
                        header("Location: ../html/login.php?error=wrongpwd");
                        exit(); 
                    }
                }
                else {
                    header("Location: ../html/login.php?error=nouserfound");
                    exit(); 
                }
            }
        }


    }
    else {
        header("Location: ../html/login.php");
        exit();
    }

?>
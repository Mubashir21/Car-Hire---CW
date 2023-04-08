<?php 

    session_start();
    
    if (isset($_POST['addbooking-button'])) {

        require 'dbh.inc.php'; 
        require 'validatenumber.inc.php';         

        $customerName = $_POST['customer-name'];
        $customerEmail = $_POST['customer-email'];
        $customerId = $_POST['customer-id'];
        $customerNumber = $_POST['customer-number'];
        $customerAge = $_POST['customer-age'];

        if (empty($customerName) || empty($customerEmail) || empty($customerId) || empty($customerNumber) || empty($customerAge)) {
            header("Location: ../html/booking.php?error=emptyfields");
            exit();
        }
        elseif (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/", $customerName)) {
            header("Location: ../html/booking.php?error=invalidemailname");
            exit();
        }
        elseif (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../html/booking.php?error=invalidemail");
            exit();
        }
        elseif (!preg_match("/^[a-zA-Z-' ]*$/", $customerName)) {
            header("Location: ../html/booking.php?error=invalidname");
            exit();
        }
        elseif (!preg_match("/^[a-zA-Z0-9]*$/", $customerId)) {
            header("Location: ../html/booking.php?error=invalidId");
            exit();
        }
        elseif (validateNumber($customerNumber) == false) {
            header("Location: ../html/booking.php?error=invalidnumber");
            exit();
        }
        elseif ($customerAge < 18 || $customerAge > 65) {
            header("Location: ../html/booking.php?error=invalidage");
            exit();
        }
        else {
            $sql = "SELECT * FROM customers WHERE identification=? AND full_name=?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../html/booking.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $customerId, $customerName);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resutcheck = mysqli_stmt_num_rows($stmt);
                if ($resutcheck == 0) {
                    $sql = "INSERT INTO customers (full_name, email, identification, age, phone_number) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../html/booking.php?error=sqlerror");
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "sssis", $customerName, $customerEmail, $customerId, $customerAge, $customerNumber);
                        mysqli_stmt_execute($stmt);
                    }
                }

                $sql = "INSERT INTO bookings (car_id, staff_id, customer_id, start_date, end_date) VALUES ((SELECT car_id FROM cars WHERE model=?), (SELECT staff_id FROM staff WHERE username=?), (SELECT customer_id FROM customers WHERE identification=?), ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../html/register.php?error=sqlerror");
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "sssss", $_SESSION['model'], $_SESSION['userName'], $customerId, $_SESSION['startdate'], $_SESSION['enddate']);
                    mysqli_stmt_execute($stmt);
                    unset($_SESSION["model"], $_SESSION["startdate"], $_SESSION["enddate"]);
                    header("Location: ../html/booking.php?booking=addedsuccessfully");
                    exit();
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }
    else {
        header("Location: ../html/booking.php");
        exit();
    }

?>
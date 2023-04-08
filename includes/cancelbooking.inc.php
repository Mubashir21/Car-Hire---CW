<?php 

    if (isset($_POST["cancel-button"])) {
        
        require 'dbh.inc.php';

        $reservationID = $_POST["reservationId"];
        $customerName = $_POST["customerName"];

        if (!preg_match("/^[0-9]*$/", $reservationID)) {
            header("Location: ../html/booking.php?error=invalidreservationid");
            exit();
        }
        elseif (!preg_match("/^[a-zA-Z-' ]*$/", $customerName)) {
            header("Location: ../html/booking.php?error=invalidname");
            exit();
        }
        else {
            $sql = "SELECT * FROM bookings INNER JOIN customers ON bookings.customer_id=customers.customer_id WHERE bookings.booking_id=? AND customers.full_name=?;";
            $stmt = mysqli_stmt_init($conn);  
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../html/boooking.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $reservationID, $customerName);
                mysqli_stmt_execute($stmt); 
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $resutcheck = mysqli_stmt_num_rows($stmt);

                if ($row > 0) {
                    $sql = "DELETE FROM bookings WHERE booking_id=?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../html/booking.php?error=sqlerror");
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $reservationID);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../html/booking.php?booking=deletedsuccessfully");
                        exit();
                    }
                }
                else {
                    header("Location: ../html/booking.php?error=nobookingfound");
                    exit();
                }
            }
        }

    }
    else {
        header("Location: ../html/booking.php");
        exit();
    }

?>
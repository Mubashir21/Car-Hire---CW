<?php 

    if (isset($_POST["cancel-button"])) {
        
        require 'dbh.inc.php';

        // gets form information
        $reservationID = $_POST["reservationId"];
        $customerName = strtolower($_POST["customerName"]);

        // handles invalid form entries
        if (!preg_match("/^[0-9]*$/", $reservationID)) {
            header("Location: ../html/booking.php?error=invalidreservationid");
            exit();
        }
        elseif (!preg_match("/^[a-zA-Z-' ]*$/", $customerName)) {
            header("Location: ../html/booking.php?error=invalidname");
            exit();
        }
        else {
            $sql = "SELECT * FROM bookings INNER JOIN customers ON bookings.customer_id=customers.customer_id WHERE bookings.booking_id=? AND customers.full_name=? and bookings.cancelled=?;";
            $stmt = mysqli_stmt_init($conn);  
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../html/boooking.php?error=sqlerror");
                exit();
            }
            else {
                $notCancelled = 0;
                mysqli_stmt_bind_param($stmt, "ssi", $reservationID, $customerName, $notCancelled);
                mysqli_stmt_execute($stmt); 
                $result = mysqli_stmt_get_result($stmt);
                $checker = mysqli_num_rows($result);

                // if bookings exists, then cancels it
                if ($checker > 0) {
                    $sql = "UPDATE bookings SET cancelled=? WHERE booking_id=?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../html/booking.php?error=sqlerror");
                        exit();
                    }
                    else {
                        $cancel = 1;
                        mysqli_stmt_bind_param($stmt, "ii", $cancel, $reservationID);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../html/booking.php?booking=deletedsuccessfully");
                        exit();
                    }
                }
                else { // if booking not found
                    header("Location: ../html/booking.php?error=nobookingfound&booking=error");
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
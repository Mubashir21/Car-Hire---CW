<?php 

    if (isset($_POST["modify-button"])) {
        
        require 'dbh.inc.php';

        $reservationID = $_POST["reservationId"];
        $reservationID = (int) $reservationID;
        $customerName = $_POST["customerName"];
        $newStartDate = $_POST["new-start-date"];
        $newEndDate = $_POST["new-end-date"];

        // check if given date is in the future
        $date1 = strtotime($newStartDate);
        $date2 = strtotime($newEndDate);
        $dateToday = strtotime(date("Y-m-d"));
        if ($date1 <= $dateToday) {
            header("Location: ../html/booking.php?error=invalidstartdate1");
            exit();
        }
        elseif ($date2 <= $date1) {
            header("Location: ../html/booking.php?error=invalidenddate");
            exit();
        }
        elseif (!preg_match("/^[0-9]*$/", $reservationID)) {
            header("Location: ../html/booking.php?error=invalidreservationid");
            exit();
        }
        elseif (!preg_match("/^[a-zA-Z-' ]*$/", $customerName)) {
            header("Location: ../html/booking.php?error=invalidname");
            exit();
        }
        else {
            // check whether new start date and new end date is different to existing start and end date
            $sql = "SELECT bookings.start_date, bookings.end_date, cars.model FROM bookings INNER JOIN cars ON cars.car_id=bookings.car_id WHERE bookings.booking_id=?";
            $stmt = mysqli_stmt_init($conn);  
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../html/booking.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "i", $reservationID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultcheck = mysqli_stmt_num_rows($stmt);
                if ($resultcheck > 0) {
                    $carModel = $row['model'];
                    if ($newStartDate == $row["start_date"] && $newEndDate == $row["end_date"]) {
                        header("Location: ../html/booking.php?error=samedatesentered");
                        exit();
                    }
                }
                else {
                    header("Location: ../html/booking.php?error=nobookingfound");
                    exit();
                }

                $sql = "SELECT * FROM bookings INNER JOIN cars on bookings.car_id=cars.car_id WHERE cars.model=? AND bookings.booking_id IN 
                        (SELECT booking_id FROM bookings WHERE (? BETWEEN start_date AND end_date) OR (? BETWEEN start_date AND end_date) AND NOT booking_id=?);";
                $stmt = mysqli_stmt_init($conn); 

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../html/booking.php?error=sqlerror");
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "sssi", $carModel, $startDate, $endDate, $reservationID);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $resutcheck = mysqli_stmt_num_rows($stmt);
                    if ($resutcheck > 0) {
                        header("Location: ../html/booking.php?booking=slotunavailable");
                        exit();
                    }
                    else {
                        $sql = "UPDATE bookings SET start_date=?, end_date=? WHERE booking_id=?;";
                        $stmt = mysqli_stmt_init($conn);  
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../html/booking.php?error=sqlerror");
                            exit();
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "ssi", $newStartDate, $newEndDate, $reservationID);
                            mysqli_stmt_execute($stmt); 
                            header("Location: ../html/booking.php?booking=modifiedsuccessfully");
                            exit();
                        }
                    }
                }
            }
        }

    }
    else {
        header("Location: ../html/booking.php");
        exit();
    }

?>
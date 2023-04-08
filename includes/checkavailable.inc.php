<?php 

    session_start();
    
    if (isset($_POST['available-button'])) {

        require 'dbh.inc.php';          

        $carType = $_POST['type'];
        $carModel = $_POST['model'];
        $startDate = $_POST['start-date'];
        $endDate = $_POST['end-date'];

        // check if given date is in the future
        $date1 = strtotime($startDate);
        $date2 = strtotime($endDate);
        $dateToday = strtotime(date("Y-m-d"));
        if ($date1 <= $dateToday) {
            header("Location: ../html/booking.php?error=invalidstartdate1");
            exit();
        }
        elseif ($date2 <= $date1) {
            header("Location: ../html/booking.php?error=invalidenddate");
            exit();
        }
        else {
            $sql = "SELECT * FROM bookings INNER JOIN cars on bookings.car_id=cars.car_id WHERE cars.model = ? AND bookings.booking_id IN 
            (SELECT booking_id FROM bookings WHERE (? BETWEEN start_date AND end_date) OR (? BETWEEN start_date AND end_date));";
            
            $stmt = mysqli_stmt_init($conn); 
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../html/booking.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "sss", $carModel, $startDate, $endDate);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resutcheck = mysqli_stmt_num_rows($stmt);
                if ($resutcheck > 0) {
                    header("Location: ../html/booking.php?booking=slotunavailable");
                    exit();
                }
                else {
                        $_SESSION['model'] = $carModel;
                        $_SESSION['startdate'] = $startDate;
                        $_SESSION['enddate'] = $endDate;
                        header("Location: ../html/booking.php?booking=slotavailable");
                        exit();
                }  
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    }
    else {
        header("Location: ../html/booking.php");
        exit();
    }

?>
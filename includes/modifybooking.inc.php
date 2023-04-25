<?php

if (isset($_POST["modify-button"])) {

    require 'dbh.inc.php';

    // gets input from form
    $reservationID = $_POST["reservationId"];
    $reservationID = (int) $reservationID;
    $customerName = strtolower($_POST["customerName"]);
    $newStartDate = $_POST["new-start-date"];
    $newEndDate = $_POST["new-end-date"];

    // check if given date is in the future
    $date1 = strtotime($newStartDate);
    $date2 = strtotime($newEndDate);
    $dateToday = strtotime(date("Y-m-d"));

    // checks for invalid form entries
    if (empty($reservationID) || empty($customerName) || empty($newStartDate) || empty($newEndDate)) {
        header("Location: ../html/booking.php?error=emptyfields");
        exit();
    } elseif ($date1 <= $dateToday) {
        header("Location: ../html/booking.php?error=invalidstartdate1");
        exit();
    } elseif ($date2 <= $date1) {
        header("Location: ../html/booking.php?error=invalidenddate");
        exit();
    } elseif (!preg_match("/^[0-9]*$/", $reservationID)) {
        header("Location: ../html/booking.php?error=invalidreservationid");
        exit();
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $customerName)) {
        header("Location: ../html/booking.php?error=invalidname");
        exit();
    } else {
        // check whether new start date and new end date is different to existing start and end date
        // also checks whether booking exists or not
        $sql = "SELECT bookings.start_date, bookings.end_date, cars.model, customers.full_name FROM bookings INNER JOIN cars ON cars.car_id=bookings.car_id INNER JOIN customers ON customers.customer_id=bookings.customer_id WHERE bookings.booking_id=? AND bookings.cancelled=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: dashboard.php?error=sqlerror");
            exit();
        } else {
            $notCancelled = 0;
            mysqli_stmt_bind_param($stmt, "ii", $reservationID, $notCancelled);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $resultcheck = mysqli_num_rows($result);
            if ($resultcheck > 0) {
                if (strcmp($customerName, $row['full_name']) != 0) {
                    header("Location: ../html/booking.php?error=nameincorrect&entered=" . $customerName . "&got=" . $row['full_name']);
                    exit();
                } elseif ($newStartDate == $row["start_date"] && $newEndDate == $row["end_date"]) {
                    header("Location: ../html/booking.php?error=samedatesentered");
                    exit();
                }
            } else {
                header("Location: ../html/booking.php?error=nobookingfound&booking=error");
                exit();
            }


            // checks if new slot is available
            $sql = "SELECT * FROM bookings INNER JOIN cars on bookings.car_id=cars.car_id WHERE cars.model=? AND bookings.cancelled=? AND bookings.booking_id IN 
                        (SELECT booking_id FROM bookings WHERE (? BETWEEN start_date AND end_date) OR (? BETWEEN start_date AND end_date) AND NOT booking_id=?);";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../html/booking.php?error=sqlerror");
                exit();
            } else {
                $notCancelled = 0;
                mysqli_stmt_bind_param($stmt, "sissi", $carModel, $notCancelled, $newStartDate, $newEndDate, $reservationID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $resutcheck = mysqli_stmt_num_rows($stmt);

                if ($resutcheck > 0) {
                    header("Location: ../html/booking.php?booking=slotunavailable");
                    exit();
                } else {

                    //retrieve the car price
                    $sql = "SELECT * FROM bookings INNER JOIN cars on bookings.car_id=cars.car_id WHERE bookings.booking_id=?;";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../html/booking.php?error=sqlerror");
                        exit();
                    } else {
                        $notCancelled = 0;
                        mysqli_stmt_bind_param($stmt, "i", $reservationID);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);

                        //update price, new start date, new end date;
                        $sql = "UPDATE bookings SET start_date=?, end_date=?, cost=? WHERE booking_id=?;";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../html/booking.php?error=sqlerror");
                            exit();
                        } else {
                            $datediff = strtotime($newEndDate) - strtotime($newStartDate);
                            $datediff = round($datediff / (60 * 60 * 24));
                            $cost_hire = $row["hire_price"] * $datediff;

                            mysqli_stmt_bind_param($stmt, "ssii", $newStartDate, $newEndDate, $cost_hire, $reservationID);
                            mysqli_stmt_execute($stmt);
                            header("Location: ../html/booking.php?booking=modifiedsuccessfully&price=".$row['hire_price']);
                            exit();
                        }
                    }



                }
            }
        }
    }

} else {
    header("Location: ../html/booking.php");
    exit();
}

?>
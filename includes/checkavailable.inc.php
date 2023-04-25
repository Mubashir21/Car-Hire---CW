<?php

session_start();

if (isset($_POST['available-button'])) {

    require 'dbh.inc.php';

    // gets data from form entry
    $carType = $_POST['type'];
    $carModel = $_POST['model'];
    $startDate = $_POST['start-date'];
    $endDate = $_POST['end-date'];

    // check if given date is in the future
    $date1 = strtotime($startDate);
    $date2 = strtotime($endDate);
    $dateToday = strtotime(date("Y-m-d"));

    // handles invalid form entries
    if (empty($carType) || empty($carModel) || empty($startDate) || empty($endDate)) {
        header("Location: ../html/booking.php?error=emptyfields");
        exit();
    } elseif ($date1 <= $dateToday) {
        header("Location: ../html/booking.php?error=invalidstartdate1");
        exit();
    } elseif ($date2 < $date1) {
        header("Location: ../html/booking.php?error=invalidenddate");
        exit();
    } elseif ($date2 == $date1) {
        header("Location: ../html/booking.php?error=samedatesentered");
        exit();
    } else {
        // checks whether slot for the particular on those dates exists
        $sql = "SELECT * FROM bookings INNER JOIN cars on bookings.car_id=cars.car_id WHERE cars.model = ? and bookings.cancelled=? AND bookings.booking_id IN 
            (SELECT booking_id FROM bookings WHERE (? BETWEEN bookings.start_date AND bookings.end_date) OR (? BETWEEN bookings.start_date AND bookings.end_date));";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../html/booking.php?error=sqlerror");
            exit();
        } else {
            $isCancelled = 0;
            mysqli_stmt_bind_param($stmt, "siss", $carModel, $isCancelled, $startDate, $endDate);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $checker = mysqli_num_rows($result);
            if ($checker > 0) { // if slot does not exist
                header("Location: ../html/booking.php?booking=slotunavailable");
                exit();
            } else { // if slot found...
                $sql = "SELECT hire_price FROM cars where model=?";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "s", $carModel);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);

                $_SESSION['model'] = $carModel;
                $_SESSION['startdate'] = $startDate;
                $_SESSION['enddate'] = $endDate;
                $_SESSION['cost'] = $row['hire_price'];
                header("Location: ../html/booking.php?booking=slotavailable");
                exit();
            }
        }
    }

} else {
    header("Location: ../html/booking.php");
    exit();
}

?>
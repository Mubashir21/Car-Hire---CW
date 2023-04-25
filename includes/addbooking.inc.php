<?php

session_start();

if (isset($_POST['addbooking-button'])) {

    require 'dbh.inc.php'; // gets the connection to database

    // gets all the inputs from the form
    $customerName = strtolower($_POST['customer-name']);
    $customerEmail = strtolower($_POST['customer-email']);
    $customerId = strtolower($_POST['customer-id']);
    $customerNumber = $_POST['customer-number'];
    $customerAge = $_POST['customer-age'];

    // checks for invalid form entries
    if (empty($customerName) || empty($customerEmail) || empty($customerId) || empty($customerNumber) || empty($customerAge)) {
        header("Location: ../html/booking.php?error=emptyfields");
        exit();
    } elseif (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/", $customerName)) {
        header("Location: ../html/booking.php?error=invalidemailname&booking=slotavailable");
        exit();
    } elseif (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../html/booking.php?error=invalidemail&booking=slotavailable");
        exit();
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $customerName)) {
        header("Location: ../html/booking.php?error=invalidname&booking=slotavailable");
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $customerId)) {
        header("Location: ../html/booking.php?error=invalidId&bbooking=slotavailable");
        exit();
    } elseif (!preg_match('/^[0-9]{10}+$/', $customerNumber)) {
        header("Location: ../html/booking.php?error=invalidnumber&booking=slotavailable");
        exit();
    } elseif ($customerAge < 18 || $customerAge > 65) {
        header("Location: ../html/booking.php?error=invalidage&booking=slotavailable");
        exit();
    } else {
        // checks whether customer already exists in database. if exists, then doesnt add to database, otherwise it does.
        $sql = "SELECT * FROM customers WHERE full_name=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../html/booking.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $customerName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resutcheck = mysqli_stmt_num_rows($stmt);

            if ($resutcheck == 0) {
                $sql = "INSERT INTO customers (full_name, email, identification, age, phone_number) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../html/booking.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "sssis", $customerName, $customerEmail, $customerId, $customerAge, $customerNumber);
                    mysqli_stmt_execute($stmt);
                }
            }

            // add the booking to the bookings table
            $sql = "INSERT INTO bookings (car_id, staff_id, customer_id, start_date, end_date, cost) VALUES ((SELECT car_id FROM cars WHERE model=?), (SELECT staff_id FROM staff WHERE username=?), (SELECT customer_id FROM customers WHERE full_name=?), ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../html/register.php?error=sqlerror");
                exit();
            } else {
                $datediff = strtotime($_SESSION['enddate']) - strtotime($_SESSION['startdate']);
                $datediff = round($datediff / (60 * 60 * 24));
                $cost_hire = $_SESSION['cost'] * $datediff;

                mysqli_stmt_bind_param($stmt, "sssssi", $_SESSION['model'], $_SESSION['userName'], $customerName, $_SESSION['startdate'], $_SESSION['enddate'], $cost_hire);
                mysqli_stmt_execute($stmt);
                $last_id = mysqli_insert_id($conn);
                header("Location: ../html/booking.php?booking=addedsuccessfully&id=" . $last_id . "&cost=" . $cost_hire);
                unset($_SESSION["model"], $_SESSION["startdate"], $_SESSION["enddate"], $_SESSION["cost"]);
                exit();
            }
        }
    }
} else {
    header("Location: ../html/booking.php");
    exit();
}

?>
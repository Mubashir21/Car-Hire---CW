<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/booking.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Dashboard</title>
</head>

<?php
require "../includes/dbh.inc.php"; // used to connect to database
include("header.php");
?>

<div class="tables">
    <div class="container">

        <h1>DASHBOARD</h1>
        <div class="first-heading">
            <?php echo "<h3>Bookings - " . date('F, Y') . "</h3>" ?>
            <span>Sorted by Start Date</span>
        </div>
        <?php
        $sql = "SELECT bookings.booking_id, cars.model, customers.full_name, bookings.start_date, bookings.end_date, bookings.cost FROM bookings INNER JOIN cars on bookings.car_id=cars.car_id INNER JOIN customers ON customers.customer_id=bookings.customer_id WHERE bookings.cancelled=? AND MONTH(bookings.start_date) = MONTH(CURRENT_DATE()) AND YEAR(bookings.start_date) = YEAR(CURRENT_DATE()) ORDER BY bookings.start_date ASC;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: dashboard.php?error=sqlerror");
            exit();
        } else {
            $isCancelled = "0";
            mysqli_stmt_bind_param($stmt, "s", $isCancelled);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $checker = mysqli_num_rows($result);
            if ($checker > 0) {
                // displays table of bookings from th database
                echo "<div class='table-cont'><table class='table'><thead><tr><th>Booking ID</th><th>Car</th><th>Customer Name</th><th>Start Date</th><th>End Date</th><th>Cost</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    // output data of each row
                    echo "<tr><td>" . $row["booking_id"] . "</td><td>" . $row["model"] . "</td><td>" . $row["full_name"] . "</td><td>" . $row["start_date"] . "</td><td>" . $row["end_date"] . "</td><td>" . $row["cost"] . "</td></tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "0 results ";
            }
        }
        ?>

        <?php echo "<h3>Car Inventory</h3>" ?>
        <?php
        $sql = "SELECT car_id, type, model, color, hire_price FROM cars;";
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: dashboard.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $checker = mysqli_num_rows($result);
            if ($checker > 0) {
                // displays the table for car inventory
                echo "<div class='table-cont'><table class=table><thead><tr><th>Car ID</th><th>Type</th><th>Model</th><th>Color</th><th>Hire Price</th></tr></thead>";
                while ($row = mysqli_fetch_assoc($result)) {
                    // output data of each row
                    echo "<tr><td>" . $row["car_id"] . "</td><td>" . $row["type"] . "</td><td>" . $row["model"] . "</td><td>" . $row["color"] . "</td><td>" . $row["hire_price"] . "</td></tr>";
                }
                echo "</table></div>";
            } else {
                echo "0 results ";
            }
        }
        ?>

        <?php echo "<h3>Customer List</h3>" ?>
        <?php
        $sql = "SELECT customer_id, full_name, email, phone_number, identification, age  FROM customers;";
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: dashboard.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $checker = mysqli_num_rows($result);
            if ($checker > 0) {
                // displays table for customers from database
                echo "<div class='table-cont'><table class=table><thead><tr><th>Customer ID</th><th>Name</th><th>Email</th><th>Phone Number</th><th>Identification</th><th>Age</th></tr></thead>";
                while ($row = mysqli_fetch_assoc($result)) {
                    // output data of each row
                    echo "<tr><td>" . $row["customer_id"] . "</td><td>" . $row["full_name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["phone_number"] . "</td><td>" . $row["identification"] . "</td><td>" . $row["age"] . "</td></tr>";
                }
                echo "</table></div>";
            } else {
                echo "0 results ";
            }
        }
        ?>
    </div>
</div>
<?php
include("footer.php");
?>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/booking.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Booking</title>
</head>

<?php
// displays the header template
include("header.php");
?>
<div class="hero">
    <div class="container">
        <h2>Bookings made <span>EASIER</span></h2>
        <div class="operation">
            <div class="panel-op">
                <ul>
                    <li id="booking-button">Book</li>
                    <li id="modify-button">Modify</li>
                    <li id="cancel-button">Cancel</li>
                </ul>
            </div>
            <div id="booking-table" class="op-selection">
                <form action="../includes/checkavailable.inc.php" method="POST">
                    <ul>
                        <li><select name="type" id="type">
                                <option value="" disabled selected hidden>Type</option>
                            </select></li>
                        <li><select name="model" id="model">
                                <option value="" disabled selected hidden>Model</option>
                            </select></li>
                        <li><!--<label for="start-date">Start date:</label>--><input type="date" name="start-date"
                                value="Start date"></li>
                        <li><!--<label for="end-date">End date:</label>--><input type="date" name="end-date"></li>
                        <li><button type="submit" name="available-button">Check Availability</button></li>
                    </ul>
                </form>
            </div>
            <div id="modify-table" class="op-selection">
                <form action="../includes/modifybooking.inc.php" method="POST">
                    <ul>
                        <li><input type="text" name="reservationId" required placeholder="Reservation ID"></li>
                        <li><input type="text" name="customerName" required placeholder="Customer Name"></li>
                        <li><!--<label for="new-start-date">New Start date:</label>--><input type="date"
                                name="new-start-date" value="Start date"></li>
                        <li><!--<label for="new-end-date">New End date:</label>--><input type="date"
                                name="new-end-date"></li>
                        <li><button type="submit" name="modify-button">Modify Booking</button></li>
                    </ul>
                </form>
            </div>
            <div id="cancel-table" class="op-selection">
                <form action="../includes/cancelbooking.inc.php" method="POST">
                    <ul>
                        <li><input type="text" name="reservationId" required placeholder="Reservation ID"></li>
                        <li><input type="text" name="customerName" required placeholder="Customer Name"></li>
                        <li><button type="submit" name="cancel-button">Cancel Booking</button></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
// displays different messages depending on the case
if (isset($_GET['booking'])) {
    if ($_GET['booking'] == 'slotavailable') {
        echo '
                    <div class="addclient-modal">
                        <div class="modal-container">
                            <p>Slot Available</p>
                            <div class="addclientform">
                                <h3>Enter customer details</h3>
                                <form action="../includes/addbooking.inc.php" method="post">
                                    <input type="text" id="customer-name" name="customer-name" required placeholder="Customer"><br>
                                    <input type="text" id="customer-email" name="customer-email" required placeholder="Email"><br>
                                    <input type="text" id="customer-id" name="customer-id" required
                                        placeholder="Identification"><br>
                                    <input type="text" id="customer-number" name="customer-number" required
                                        placeholder="Phone number (eg. 0167120875)"><br>
                                    <input type="number" name="customer-age" id="customer-age" required placeholder="Age"><br>
                                    <button type="submit" name="addbooking-button">Make booking</button>
                                </form>
                            </div>
                        </div>
                    </div>';
    } elseif ($_GET['booking'] == 'addedsuccessfully') {
        echo '
            <div class="error-modal">
                <div class="modal-container">
                    <span id="close">&times;</span>
                    <p>Booking Successful</p>
                    <span class="message">Reservation ID: <span>000' . $_GET['id'] . '</span><br>Total price: <span>RM' . $_GET['cost'] . '</span></span>
                </div>
            </div>';
    } elseif ($_GET['booking'] == 'deletedsuccessfully') {
        echo '
            <div class="error-modal">
                <div class="modal-container">
                    <span id="close">&times;</span>
                    <p>Booking Cancelled</p>
                </div>
            </div>';
    } elseif ($_GET['booking'] == 'modifiedsuccessfully') {
        echo '
            <div class="error-modal">
                <div class="modal-container">
                    <span id="close">&times;</span>
                    <p>Booking Modified</p>
                </div>
            </div>';
    }
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'invalidemailname') {
            echo '<div class="error-modal">
                        <div class="modal-container">
                            <span id="close">&times;</span>
                            <p>Invalid name/email.</p>
                        </div>
                    </div>';
        } elseif ($_GET['error'] == 'invalidname') {
            echo '<div class="error-modal">
                        <div class="modal-container">
                            <span id="close">&times;</span>
                            <p>Invalid name.</p>
                        </div>
                    </div>';
        } elseif ($_GET['error'] == 'invalidemail') {
            echo '<div class="error-modal">
                        <div class="modal-container">
                            <span id="close">&times;</span>
                            <p>Invalid email address.</p>
                        </div>
                    </div>';
        } elseif ($_GET['error'] == 'invalidId') {
            echo '<div class="error-modal">
                        <div class="modal-container">
                            <span id="close">&times;</span>
                            <p>Invalid ID.</p>
                        </div>
                    </div>';
        } elseif ($_GET['error'] == 'invalidnumber') {
            echo '<div class="error-modal">
                        <div class="modal-container">
                            <span id="close">&times;</span>
                            <p>Invalid number.</p>
                        </div>
                    </div>';
        } elseif ($_GET['error'] == 'invalidage') {
            echo '<div class="error-modal">
                        <div class="modal-container">
                            <span id="close">&times;</span>
                            <p>Invalid age.</p>
                        </div>
                    </div>';
        }
    }
    if ($_GET['booking'] == 'error' && $_GET['error'] == 'nobookingfound') {
        echo '<div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>No booking found.</p>
                    </div>
                </div>';
    } elseif ($_GET['booking'] == 'slotunavailable') {
        echo '
                <div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>Slot unavailable. Try again.</p>
                    </div>
                </div>';
    }
} ?>
<?php if (isset($_GET['error'])) {
    if ($_GET['error'] == 'emptyfields') {
        echo '<div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>Fill out all the fields.</p>
                    </div>
                </div>';
    } elseif ($_GET['error'] == 'invalidstartdate1') {
        echo '
                <div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>Start date entered is invalid.</p>
                    </div>
                </div>';
    } elseif ($_GET['error'] == 'invalidenddate') {
        echo '
                <div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>End date entered is invalid.</p>
                    </div>
                </div>';
    } elseif ($_GET['error'] == 'invalidreservationid') {
        echo '
                <div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>Invalid reservation ID.</p>
                    </div>
                </div>';
    } elseif ($_GET['error'] == 'invalidname') {
        echo '
                <div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>Invalid name entered.</p>
                    </div>
                </div>';
    } elseif ($_GET['error'] == 'sqlerror') {
        echo '
                <div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>Database connection error.</p>
                    </div>
                </div>';
    }
    elseif ($_GET['error'] == 'nameincorrect') {
        echo '
                <div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>Name does not match with booking.</p>
                    </div>
                </div>';
    }
    elseif ($_GET['error'] == 'samedatesentered') {
        echo '
                <div class="error-modal">
                    <div class="modal-container">
                        <span id="close">&times;</span>
                        <p>Same dates entered.</p>
                    </div>
                </div>';
    }
}
?>
<main>
    <div class="container">
        <h1>
            INVENTORY
        </h1>
        <div class="grid-container" id="grid">
            <div class="heading">
                <p>SPORTS</p>
            </div>
            <div class="heading">
                <p>LUXURY</p>
            </div>
            <div class="heading">
                <p>CLASSIC</p>
            </div>
            <a class="grid-1 cont" href="#" onClick="return false;"><img class="img-1 thumb"
                    src="../media/car pictures/430scud.jpg" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Ferrari 430 Scuderia</div>
                    <div class="text">RM 6000/day</div>
                </div>
            </a>
            <a class="grid-2 cont" href="#" onClick="return false;"><img class="img-2 thumb"
                    src="../media/car pictures/phantom.jpg" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Rolls Royce Phantom</div>
                    <div class="text">RM 9800/day</div>
                </div>
            </a>
            <a class="grid-3 cont" href="#" onClick="return false;"><img class="img-3 thumb"
                    src="../media/car pictures/mk2.jpg" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Jaguar MK 2</div>
                    <div class="text">RM 2200/day</div>
                </div>
            </a>
            <a class="grid-4 cont" href="#" onClick="return false;"><img class="img-4 thumb"
                    src="../media/car pictures/boxster.jpg" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Porsche Boxster</div>
                    <div class="text">RM 2800/day</div>
                </div>
            </a>
            <a class="grid-5 cont" href="#" onClick="return false;"><img class="img-5 thumb"
                    src="../media/car pictures/cls350.webp" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Mercedes Benz CLS 350</div>
                    <div class="text">RM 1350/day</div>
                </div>
            </a>
            <a class="grid-6 cont" href="#" onClick="return false;"><img class="img-6 thumb"
                    src="../media/car pictures/rr limo.webp" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Rolls Royce Silver Spirit Limousine</div>
                    <div class="text">RM 3200/day</div>
                </div>
            </a>
            <a class="grid-7 cont" href="#" onClick="return false;"><img class="img-7 thumb"
                    src="../media/car pictures/sc430.jpg" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Lexus SC430</div>
                    <div class="text">RM 1600/day</div>
                </div>
            </a>
            <a class="grid-8 cont" href="#" onClick="return false;"><img class="img-8 thumb"
                    src="../media/car pictures/stype.jpg" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Jaguar S Type</div>
                    <div class="text">RM 1350/day</div>
                </div>
            </a>
            <a class="grid-9 cont" href="#" onClick="return false;"><img class="img-9 thumb"
                    src="../media/car pictures/mg td.jpg" alt="image of car" />
                <div class="overlay">
                    <div class="heading">MG TD</div>
                    <div class="text">RM 2500/day</div>
                </div>
            </a>
            <a class="grid-10 cont" href="#" onClick="return false;"><img class="img-9 thumb"
                    src="../media/car pictures/murci.jpg" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Lamborghini Murcielago LP640</div>
                    <div class="text">RM 7000/day</div>
                </div>
            </a>
            <a class="grid-11 cont" href="#" onClick="return false;"><img class="img-9 thumb"
                    src="../media/car pictures/bentley.jpg" alt="image of car" />
                <div class="overlay">
                    <div class="heading">Bentley Continental Flying Spur</div>
                    <div class="text">RM 4800/day</div>
                </div>
            </a>
        </div>
    </div>
</main>
<?php
// displays the footer template
include("footer.php");
?>

</html>
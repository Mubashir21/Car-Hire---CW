<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="../css/booking.css">-->
    <title>Booking</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <p>Executive Car Hire</p>
            <nav>
                <ul>
                    <?php
                        echo "<li>Welcome, ".$_SESSION['userName']."</li>";
                    ?>
                    <li><a href="../includes/logout.inc.php">Log out</a></li>
                </ul>
            </nav>
        </header>
        <div class="hero">
            <div class="hero-container">
                <h2>Make a booking</h2>
                <table>
                        <tr>
                            <td id="booking-button">
                                <p>Book</p>
                            </td>
                            <td id="modify-button">
                                <p>Modify</p>                        
                            </td>
                            <td id="cancel-button">
                                <p>Cancel</p>
                            </td>
                        </tr>
                </table>
                <table id="booking-table">
                    <form action="../includes/checkavailable.inc.php" method="POST">
                        <tr>
                            <td>
                                <select name="type" id="type">
                                <option value="" disabled selected hidden>Type</option>
                                </select>
                            </td>
                            <td>                        
                                <select name="model" id="model">
                                <option value="" disabled selected hidden>Model</option>
                                </select>
                            </td>
                            <td>
                                <label for="start-date">Start date:</label>
                                <input type="date" name="start-date">
                            </td>
                            <td>
                                <label for="end-date">End date:</label>
                                <input type="date" name="end-date">
                            </td>
                            <td>
                                <button type="submit" name="available-button">Check Availability</button>
                            </td>
                        </tr>
                    </form>
                </table>
                <table id="modify-table">
                    <form action="../includes/modifybooking.inc.php" method="POST">
                        <tr>
                            <td>
                                <input type="text" name="reservationId" required placeholder="Reservation ID">
                            </td>
                            <td>
                                <input type="text" name="customerName" required placeholder="Customer Name">
                            </td>
                            <td>
                                <label for="new-start-date">New Start date:</label>
                                <input type="date" name="new-start-date">
                            </td>
                            <td>
                                <label for="new-end-date">New End date:</label>
                                <input type="date" name="new-end-date">
                            </td>
                            <td>
                                <button type="submit" name="modify-button">Modify Booking</button>
                            </td>
                        </tr>
                    </form>
                </table>
                <table id="cancel-table">
                    <form action="../includes/cancelbooking.inc.php" method="POST">
                        <tr>
                            <td>
                                <input type="text" name="reservationId" required placeholder="Reservation ID">
                            </td>
                            <td>
                                <input type="text" name="customerName" required placeholder="Customer Name">
                            </td>
                            <td>
                                <button type="submit" name="cancel-button">Cancel Booking</button>
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
        <?php if (isset($_GET['booking'])) {
            if ($_GET['booking'] == 'slotavailable') { ?>
            <div class="addclient">
                <div class="addclientform">
                    <h3>Enter customer details</h3>
                    <form action="../includes/addbooking.inc.php" method="post">
                        <input type="text" id="customer-name" name="customer-name" required placeholder="Customer"><br>
                        <input type="text" id="customer-email" name="customer-email" required placeholder="Email"><br>
                        <input type="text" id="customer-id" name="customer-id" required placeholder="Identification"><br>
                        <input type="text" id="customer-number" name="customer-number" required placeholder="Phone number"><br>
                        <input type="number" name="customer-age" id="customer-age" required placeholder="Age"><br>
                        <button type="submit" name="addbooking-button">Make booking</button>
                    </form>
                </div>
            </div>
        <?php }} ?>
        <main>
            <h1>
                Inventory
            </h1>
            <div class="row0">
                <div class="column">
                    <p>Sports</p>
                </div>
                <div class="column">
                    <p>Classic</p>
                </div>
                <div class="column">
                    <p>Luxury</p>
                </div>
            </div>
            <div class="row1">
                <div class="column">
                    <a class="grid-1" href="/458speciale">
                        <img class="img-1 thumb" src="" alt="image of car"/>
                    </a>
                </div>
                <div class="column">
                    <a class="grid-1" href="/458speciale">
                        <img class="img-1 thumb" src="" alt="image of car"/>
                    </a>
                </div>
                <div class="column">
                    <a class="grid-1" href="/458speciale">
                        <img class="img-1 thumb" src="" alt="image of car"/>
                    </a>
                </div>
            </div>
            <div class="row2">
                <div class="column">
                    <a class="grid-1" href="/458speciale">
                        <img class="img-1 thumb" src="" alt="image of car"/>
                    </a>
                </div>
                <div class="column">
                    <a class="grid-1" href="/458speciale">
                        <img class="img-1 thumb" src="" alt="image of car"/>
                    </a>
                </div>
                <div class="column">
                    <a class="grid-1" href="/458speciale">
                        <img class="img-1 thumb" src="" alt="image of car"/>
                    </a>
                </div>
            </div>
            <div class="row3">
                <div class="column">
                    <a class="grid-1" href="/458speciale">
                        <img class="img-1 thumb" src="" alt="image of car"/>
                    </a>
                </div>
                <div class="column">
                    <a class="grid-1" href="/458speciale">
                        <img class="img-1 thumb" src="" alt="image of car"/>
                    </a>
                </div>
                <div class="column">
                    <a class="grid-1" href="/458speciale">
                        <img class="img-1 thumb" src="" alt="image of car"/>
                    </a>
                </div>
            </div>
        </main>
        <footer>
            <div class="footer-bottom">
            <h4>Back to top</h4>
            <a href="#" class="arrow-top"
                ><img src="static/photos/arrow-top.svg" alt="go to top button"
            /></a>
            </div>
        </footer>
    </div>
    <script>
        var typeObject = 
        {
            "Car": {
            "Luxury": ["Rolls Royce Phantom", "Bentley Continental Flying Spur", "Mercedes Benz CLS 350", "Jaguar S Type"],
            "Sports": ["Ferrari F430 Scuderia", "Lamborghini Murcielago LP640", "Porsche Boxster", "Lexus SC430"],
            "Classic": ["Jaguar MK 2", "Rolls Royce Silver Spirit Limousine", "MG TD"]
            }
        }

        window.onload = function() 
        {
            var typeSel = document.getElementById("type");
            var modelSel = document.getElementById("model");
            for (var x in typeObject["Car"]) {
                typeSel.options[typeSel.options.length] = new Option(x, x);
            }
            typeSel.onchange = function() {
                //empty Chapters dropdown
                modelSel.length = 1;
                //display correct values
                var z = typeObject["Car"][this.value];
                for (var i = 0; i < z.length; i++) {
                modelSel.options[modelSel.options.length] = new Option(z[i], z[i]);
                }
            }
        }

        var booking = document.getElementById("booking-button");
        var modify = document.getElementById("modify-button");
        var cancel = document.getElementById("cancel-button");
        document.getElementById("modify-table").style.display = "none";
        document.getElementById("cancel-table").style.display = "none";

        booking.onclick = function() {
            if (document.getElementById("booking-table").style.display === "none") {
                document.getElementById("booking-table").style.display = "block";
                document.getElementById("modify-table").style.display = "none";
                document.getElementById("cancel-table").style.display = "none";
            }
            else {
                document.getElementById("booking-table").style.display = "none";
            } 
        }
        modify.onclick = function() {
            if (document.getElementById("modify-table").style.display === "none") {
                document.getElementById("booking-table").style.display = "none";
                document.getElementById("modify-table").style.display = "block";
                document.getElementById("cancel-table").style.display = "none";
            }
            else {
                document.getElementById("modify-table").style.display = "none";
            } 
        }
        cancel.onclick = function() {
            if (document.getElementById("cancel-table").style.display === "none") {
                document.getElementById("booking-table").style.display = "none";
                document.getElementById("modify-table").style.display = "none";
                document.getElementById("cancel-table").style.display = "block";
            }
            else {
                document.getElementById("cancel-table").style.display = "none";
            } 
        }
    </script>
</body>
</html>
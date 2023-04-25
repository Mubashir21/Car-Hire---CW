<!-- the header template -->

<?php
session_start();
?>
<body>
<div class="loaderwrapper" id="loaderwrapper">
    <span class="loader">
        <span class="loader-inner">
        </span>
    </span>
</div>
<div class="navbar">
    <div class="container">
        <p>Executive Car Hire</p>
        <nav>
            <ul class="first">
                <?php
                echo "<li>Welcome, <span>" . ucwords($_SESSION['userName']) . "</span></li>";
                ?>
            </ul>
            <ul class="second">
                <li><a href="booking.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="../includes/logout.inc.php">Log Out</a></li>
            </ul>
        </nav>
    </div>
</div>
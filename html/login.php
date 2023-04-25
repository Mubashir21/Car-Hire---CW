<!-- login page -->

<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="loaderwrapper" id="loaderwrapper">
        <span class="loader">
            <span class="loader-inner">
            </span>
        </span>
    </div>
    <div class="wrapper">
        <div class="login-left">
            <div class="top">
                <h1>Executive Car Hire</h1>
            </div>
        </div>
        <div class="login-right">
            <div class="form-area">
                <h2>Login</h2>
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 'emptyfields') {
                        echo '<p class="login-error">Fill in all fields!</p>';
                    } elseif ($_GET['error'] == 'wrongpwd') {
                        echo '<p class="login-error">Password is incorrect!</p>';
                    } elseif ($_GET['error'] == 'nouserfound') {
                        echo '<p class="login-error">User does not exist!</p>';
                    }
                } elseif (isset($_GET['login'])) {
                    if ($_GET['login'] == 'success') {
                        echo '<p class="login-success">Logged in!</p>';
                    }
                }
                ?>
                <form action="../includes/login.inc.php" method="post">
                    <input type="text" id="username" name="emailuid" required placeholder="Username/Email"><br>
                    <input type="password" name="password" id="pasword" required placeholder="Password">
                    <button type="submit" name="login-button">Login</button>
                </form>
                <p>Not registered? <a href="./register.php">Sign Up</a></p>
            </div>
        </div>
    </div>
</body>
<script>
    // loaderscreen
    $(window).on("load", function () {
        $('html, body').css({ 'overflow': 'hidden', 'height': '100%' });
        setTimeout(() => {
            $(".loaderwrapper").fadeOut("slow");
            $('html, body').css({ 'overflow': 'visible', 'height': '100%' });
        }, 700);
    });
</script>

</html>
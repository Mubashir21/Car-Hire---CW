<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins:wght@200;400;700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="login-left">       
                <div class="top">
                    <h1>Executive Car Hire</h1>
                    <p>Lorem ipsum dolor sit amet.</p>
                </div>                      
            </div>
            <div class="login-right">            
                <div class="form-area">
                    <h2>Login</h2>
                    <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'emptyfields') {
                                echo '<p class="login-error">Fill in all fields!</p>';
                            }
                            elseif ($_GET['error'] == 'wrongpwd') {
                                echo '<p class="login-error">Password is incorrect!</p>';
                            }
                            elseif ($_GET['error'] == 'nouserfound') {
                                echo '<p class="login-error">User does not exist!</p>';
                            }
                        }
                        elseif (isset($_GET['login'])) {
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
</html>
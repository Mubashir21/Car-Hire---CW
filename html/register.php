<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
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
                    <h2>Register</h2>
                    <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'emptyfields') {
                                echo '<p class="register-error">Fill in all fields!</p>';
                            }
                            elseif ($_GET['error'] == 'invalidemailusername') {
                                echo '<p class="register-error">Invalid email and username!</p>';
                            }
                            elseif ($_GET['error'] == 'invalidemail') {
                                echo '<p class="register-error">Invalid email!</p>';
                            }
                            elseif ($_GET['error'] == 'invalidusername') {
                                echo '<p class="register-error">Invalid username!</p>';
                            }
                            elseif ($_GET['error'] == 'passwordcheck') {
                                echo '<p class="register-error">Passwords do not match!</p>';
                            }
                            elseif ($_GET['error'] == 'usertaken') {
                                echo '<p class="register-error">Username already taken!</p>';
                            }
                        }
                        elseif (isset($_GET['register'])) {
                            if ($_GET['register'] == 'success') {
                                echo '<p class="register-success">Registered successfully!</p>';  
                            } 
                        }
                    ?>
                    <form action="../includes/register.inc.php" method="post">
                        <input type="text" id="username" name="username" required placeholder="Username"><br>
                        <input type="text" id="email" name="email" required placeholder="Email address"><br>
                        <input type="password" id="password" name="password" required placeholder="Password"><br>
                        <input type="password" id="passwordrepeat" name="passwordrepeat" required placeholder="Re-Enter Password">
                        <button type="submit" name="register-button">Register</button>
                    </form>
                    <p>Already a user? Login <a href="./login.php">Login</a></p>
                </div>
            </div>
        </div>
    </body>
</html>
<?php

    if(!isset($_SESSION)){
        session_start();
    }

    $email = $_SESSION['login-data']['email'] ?? null;
    $password = $_SESSION['login-data']['password'] ?? null;
    unset($_SESSION['login-data']);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="assets/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="style/general.css">

    <script src="https://kit.fontawesome.com/32dee845d7.js" crossorigin="anonymous"></script>
    <script defer src="javascript/msgBox.js"></script>
    
    <title>Login</title>
</head>
<body>
    <?php if(isset($_SESSION['login'])):?>
        <?= $_SESSION['login'];
            unset($_SESSION['login']);
        ?>
    <?php endif ?>
    <?php if(isset($_SESSION['deleteAccount'])):?>
        <?= $_SESSION['deleteAccount'];
            unset($_SESSION['deleteAccount']);
        ?>
    <?php endif ?>
    <div class="auth-container">
        <div class="main-auth-container">
            <div class="auth-form-container">
                <div class="auth-img-container">
                    <img src="assets/login-img.png" alt="loging in">
                </div>
                <form action="login-logic.php" method="POST">
                    <div>
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?= $email ?>">
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" value="<?= $password ?>">
                    </div>
                    <div>
                        <input type="submit" name="signin" class="btn" value="Login">
                    </div>
                    <div>
                        <small>Don't have an account yet? <a href="register.php">Register now</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
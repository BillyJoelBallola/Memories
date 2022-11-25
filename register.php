<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    $username = $_SESSION['register-data']['username'] ?? null;
    $email = $_SESSION['register-data']['email'] ?? null;
    $createpassword = $_SESSION['register-data']['createpassword'] ?? null;
    $confirmpassword = $_SESSION['register-data']['confirmpassword'] ?? null;

    unset($_SESSION['register-data']);
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
    
    <title>Register</title>
</head>
<body>
    <?php if(isset($_SESSION['register'])): ?>
        <?= 
            $_SESSION['register'];
            unset($_SESSION['register']);
        ?>
    <?php endif ?>
    <div class="auth-container">
        <div>
            <div class="auth-form-container register-container">
                <form action="register-logic.php" method="POST" class="register-form">
                    <div>
                    <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= $username ?>">
                    </div>
                    <div>
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?= $email ?>">
                    </div>
                    <div>
                        <label for="createpassword">Create Password</label>
                        <input type="password" id="createpassword" name="createpassword" value="<?= $createpassword ?>">
                    </div>
                    <div>
                        <label for="confirmpassword">Confirm Password</label>
                        <input type="password" id="confirmpassword" name="confirmpassword" value="<?= $confirmpassword ?>">
                    </div>
                    <div>
                        <input type="submit" name="submit" class="btn" value="Register">
                    </div>
                    <div>
                        <small>Already have an account? <a href="login.php">Login now</a></small>
                    </div>
                </form>
                <div class="auth-img-container register-img">
                    <img src="assets/register-img.png" alt="loging in"> 
                </div>
            </div>
        </div>
    </div>
</body>
</html>
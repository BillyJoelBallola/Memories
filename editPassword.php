<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['userLogin'])){
        header("Location: login.php");
    }

    require('dbConnect.php');
    $conn = connection();

    $userId = $_SESSION['userId'];
    $msg = '' ;

    $getUserById_query = "SELECT * FROM users WHERE id = '$userId'";
    $user = $conn->query($getUserById_query) or die ($conn->error);
    $row = $user->fetch_assoc();
    $total = $user->num_rows;

    if(isset($_POST['save'])){
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if(empty($currentPassword) || empty($newPassword) || empty($confirmPassword)){
            $_SESSION['editPassword'] = '<div class="msgBox">
                                            <div>
                                                <i class="fa-solid fa-circle-exclamation error"></i>
                                                <p>Fill up all fields</p>
                                            </div>
                                            <span class="msgBox-close">&times;</span>
                                        </div>';
        }elseif($currentPassword != $row['password']){
            $_SESSION['editPassword'] = '<div class="msgBox">
                                            <div>
                                                <i class="fa-solid fa-circle-exclamation error"></i>
                                                <p>Current password is incorrect</p>
                                            </div>
                                            <span class="msgBox-close">&times;</span>
                                        </div>';    
        }elseif($confirmPassword != $newPassword){
            $_SESSION['editPassword'] = '<div class="msgBox">
                                            <div>
                                                <i class="fa-solid fa-circle-exclamation error"></i>
                                                <p>Confirm password did not match to new password</p>
                                            </div>
                                            <span class="msgBox-close">&times;</span>
                                        </div>';
        }

        if(isset($_SESSION['editPassword'])){
            $_SESSION['editPassword-data'] = $_POST;
        }else{
            $updateUsernameById_query = "UPDATE users SET `password` = '$newPassword' WHERE `id` = '$userId'";
            $data = $conn->query($updateUsernameById_query) or die ($conn->error);

            $msg = 'Click back button to redirect to login page.';
            $_SESSION['editPassword'] = '<div class="msgBox">
                                            <div>
                                                <i class="fa-solid fa-circle-exclamation success"></i>
                                                <p>Password updated successfully</p>
                                            </div>
                                            <span class="msgBox-close">&times;</span>
                                        </div>';
            unset($_SESSION['userLogin']);                                        
            unset($_SESSION['userId']);                                        
        }
    }

    $currentPassword = $_SESSION['editPassword-data']['currentPassword'] ?? null;
    $newPassword = $_SESSION['editPassword-data']['newPassword'] ?? null;
    $confirmPassword = $_SESSION['editPassword-data']['confirmPassword'] ?? null;

    unset($_SESSION['editPassword-data']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="assets/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="style/general.css">
    
    <script defer src="https://kit.fontawesome.com/32dee845d7.js" crossorigin="anonymous"></script>
    <script defer src="javascript/msgBox.js"></script>

    <title>Memories | My Account</title>
</head>
<body>
    <?php if(isset($_SESSION['editPassword'])): ?>
        <?= $_SESSION['editPassword'];
            unset($_SESSION['editPassword']);
        ?>
    <?php endif ?>
    <div class="myAccount-container">
        <div class="myAccount-content">
            <div class="myAccount-header">
                <a href="myAccount.php">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1>My Account | Password</h1>
            </div>
            <div class="myAccount">
                <form class="editAccount-form" action="" method="POST">
                    <div>
                        <label for="currentPassword">Current password</label>
                        <input type="password" id="currentPassword" name="currentPassword" value="<?= $currentPassword ?>">
                    </div>
                    <div>
                        <label for="newPassword">New password</label>
                        <input type="password" id="newPassword" name="newPassword" value="<?= $newPassword ?>">
                    </div>
                    <div>
                        <label for="confirmPassword">Confirm new password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" value="<?= $confirmPassword ?>">
                    </div>
                    <div>
                        <input class="btn" type="submit" name="save" value="Save">
                    </div>
                </form>
                <small><?= $msg ?></small>
            </div>
        </div>     
    </div>
</body>
</html>
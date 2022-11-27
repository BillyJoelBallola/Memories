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
        $newUsername = $_POST['newUsername'];
        $password = $_POST['password'];

        if(empty($newUsername) || empty($password)){
            $_SESSION['editUsername'] = '<div class="msgBox">
                                            <div>
                                                <i class="fa-solid fa-circle-exclamation error"></i>
                                                <p>Fill up all fields</p>
                                            </div>
                                            <span class="msgBox-close">&times;</span>
                                        </div>';
        }elseif($password != $row['password']){
            $_SESSION['editUsername'] = '<div class="msgBox">
                                            <div>
                                                <i class="fa-solid fa-circle-exclamation error"></i>
                                                <p>Password did not match</p>
                                            </div>
                                            <span class="msgBox-close">&times;</span>
                                        </div>';
        }

        if(isset($_SESSION['editUsername'])){
            $_SESSION['editUsername-data'] = $_POST;
        }else{
            $updateUsernameById_query = "UPDATE users SET `username` = '$newUsername' WHERE `id` = '$userId'";
            $data = $conn->query($updateUsernameById_query) or die ($conn->error);

            $msg = 'Click back button to redirect to login page, and start re-logging';
            $_SESSION['editUsername'] = '<div class="msgBox">
                                            <div>
                                                <i class="fa-solid fa-circle-exclamation success"></i>
                                                <p>Username updated successfully</p>
                                            </div>
                                            <span class="msgBox-close">&times;</span>
                                        </div>';
            unset($_SESSION['userLogin']);                                        
            unset($_SESSION['userId']);                                        
        }
    }

    $newUsername = $_SESSION['editUsername-data']['newUsername'] ?? null;
    $password = $_SESSION['editUsername-data']['password'] ?? null;

    unset($_SESSION['editUsername-data']);

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
    <?php if(isset($_SESSION['editUsername'])): ?>
        <?= $_SESSION['editUsername'];
            unset($_SESSION['editUsername']);
        ?>
    <?php endif ?>
    <div class="myAccount-container">
        <div class="myAccount-content">
            <div class="myAccount-header">
                <a href="myAccount.php">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1>My Account | Username</h1>
            </div>
            <div class="myAccount">
                <form class="editAccount-form" action="" method="POST">
                    <div>
                        <label for="newUsername">New username</label>
                        <input type="text" id="newUsername" name="newUsername" value="<?= $newUsername ?>">
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"  value="<?= $password ?>">
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
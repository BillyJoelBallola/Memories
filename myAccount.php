<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['userLogin'])){
        header('Location: login.php');
    }

    require('dbConnect.php');
    $conn = connection();

    $currentPassError = '';
    $emptyError = '';

    $userId = $_SESSION['userId'];
    $username = $_SESSION['userLogin'];

    $getUserById_query = "SELECT * FROM users WHERE id = '$userId'";
    $user = $conn->query($getUserById_query) or die ($conn->error);
    $row = $user->fetch_assoc();
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

    <title>Memories | My Account</title>
</head>
<body>
    <div class="myAccount-container">
        <div class="myAccount-content">
            <div class="myAccount-header">
                <a href="index.php">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1>My Account</h1>
            </div>
            <div class="myAccount">
                <div>
                    <div class="text">
                        <span>Username</span>
                        <p><?php echo $row['username'] ?></p>
                    </div>
                    <div>
                        <a href="editUsername.php" class="btn">Edit</a>
                    </div>
                </div>
                <div>
                    <div class="text">
                        <span>Email Address</span>
                        <p><?php echo $row['email'] ?></p>
                    </div>
                    <div>
                        <a href="editEmail.php" class="btn">Edit</a>
                    </div>
                </div>
                <div>
                    <div class="text">
                        <span>Password</span>
                        <p>•••••</p>
                    </div>
                    <div>
                        <a href="editPassword.php" class="btn">Edit</a>
                    </div>
                </div>
            </div>
            <div class="myAccount-other-control"> 
                <a href="deleteAccount.php" class="btn">Delete Account</a>
                <a href="logout.php" class="btn myAccount-logout">Logout</a>
            </div>
        </div>     
    </div>
</body>
</html>
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

    $getUserById_query = "SELECT * FROM users WHERE id = '$userId'";
    $user = $conn->query($getUserById_query) or die ($conn->error);
    $row = $user->fetch_assoc();

    if(isset($_POST['delete'])){
        $reason = $_POST['reason'];
        $otherReason = $_POST['otherReason'] ? $_POST['otherReason'] : 'N/A';

        if(empty($reason)){
            $_SESSION['deleteAccount'] = '<div class="msgBox">
                                            <div>
                                                <i class="fa-solid fa-circle-exclamation error"></i>
                                                <p>Reason cannot be empty</p>
                                            </div>
                                            <span class="msgBox-close">&times;</span>
                                        </div>';
        }

        if(isset($_SESSION['deleteAccount'])){
            $_SESSION['deleteAccount-data'] = $_POST;
        }else{
            $userEmailAddress = $row['email'];

            $insertReason_query = "INSERT INTO `reasons` (`emailAddress`, `reason`, `otherReason`) VALUES ('$userEmailAddress', '$reason', '$otherReason')";
            $conn->query($insertReason_query) or die ($conn->error);

            $deleteUser_query = "DELETE FROM users WHERE id = '$userId'";
            $conn->query($deleteUser_query) or die ($conn->error);

            $_SESSION['deleteAccount'] = '<div class="msgBox">
                                            <div>
                                                <i class="fa-solid fa-circle-exclamation success"></i>
                                                <p>Your account has been deleted permanently</p>
                                            </div>
                                            <span class="msgBox-close">&times;</span>
                                        </div>';
            include('logout.php');                                    
        }
    }

    // $currentPassword = $_SESSION['deleteAccount-data']['currentPassword'] ?? null;
    // $newPassword = $_SESSION['deleteAccount-data']['newPassword'] ?? null;
    // $confirmPassword = $_SESSION['deleteAccount-data']['confirm$confirmPassword'] ?? null;

    // unset($_SESSION['deleteAccount-data']);

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
    <?php if(isset($_SESSION['deleteAccount'])): ?>
        <?= $_SESSION['deleteAccount'];
            unset($_SESSION['deleteAccount']);
        ?>
    <?php endif ?>
    <div class="myAccount-container">
        <div class="myAccount-content">
            <div class="myAccount-header">
                <h1>Deleting Account</h1>
            </div>
            <div class="myAccount">
                <form class="editAccount-form" id="editAccount-form" method="POST">
                    <div>
                        <select name="reason">
                            <option value="">-- Select reason for deleting the account ---</option>
                            <option value="I dont use memories diary anymore">I don't use memories diary anymore</option>
                            <option value="I dont have to time to write memory">I don't have to time to write memory</option>
                            <option value="I dont want to remember the past">I don't want to remember the past</option>
                            <option value="I dont like using it">I dont't like using it</option>
                        </select>
                    </div>
                    <div>
                        <label for="otherReason">Other reason</label>
                        <textarea name="otherReason" id="" cols="30" rows="5"></textarea>
                    </div>
                </form>
                <small>All the saved work and information will be deleted permanently</small>
                <div class="deleteAccount-control">
                    <input class="btn" type="submit" name="delete" form="editAccount-form" value="Delete Account">
                    <a href="myAccount.php" class="btn" name="save">Cancel</a>
                </div>
            </div>
        </div>     
    </div>
</body>
</html>
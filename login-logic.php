<?php

    if(!isset($_SESSION)){
        session_start();
    }
    
    require('dbConnect.php');
    $conn = connection();

    if(isset($_POST['signin'])){
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];

        $getUsers_query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $data = $conn->query($getUsers_query) or die ($conn->error);
        $row = $data->fetch_assoc();
        
        $dbid = $row['id'];
        $dbusername = $row['username'];
        $dbemail = $row['email'];
        $dbpassword = $row['password'];
        
        if(empty($email) || empty($password)){
            $_SESSION['login'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Complete the login form</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';

        }elseif($dbemail != $email || $dbpassword != $password){
            $_SESSION['login'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>User not found</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }

        if ($_SESSION['login']){
            $_SESSION['login-data'] = $_POST;
            header('Location: login.php');
            die();
        }else{
            session_start();
            $_SESSION['userLogin'] = $dbusername;
            $_SESSION['userId'] = $dbid;
            header('Location: index.php'); 
            die();
        }

    }else{
        header('Location: login.php');
        die();
    }
?>

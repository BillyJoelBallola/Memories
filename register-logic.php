<?php

    if(!isset($_SESSION)){
        session_start();
    }

    require('dbConnect.php');
    $conn = connection();    

    if(isset($_POST['submit'])){
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $getEmail_query = "SELECT * FROM users WHERE email = '$email'";
        $data = $conn->query($getEmail_query) or die ($conn->error);
        $result = $data->num_rows;

        if($result != 0){
            while($row = $data->fetch_assoc()){
                $dbemail = $row['email'];
            }
        }

        if(empty($username) || empty($email) || empty($createpassword) || empty($confirmpassword)){
            $_SESSION['register'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Complete the registration form</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }elseif (($dbemail == $email)){
            $_SESSION['register'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Email already registered</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }elseif ((strlen($username) < 6) || (strlen($username) > 11)){
            $_SESSION['register'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Username should range 5 - 10 characters</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }elseif ((strlen($createpassword) < 6) || (strlen($createpassword) > 16)){
            $_SESSION['register'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Password should range 5 - 15 characters</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }elseif ((strlen($confirmpassword) < 6) || (strlen($confirmpassword) > 16)){
            $_SESSION['register'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Password should range 5 - 15 characters</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }elseif($createpassword !== $confirmpassword){
            $_SESSION['register'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Password did not match</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        } 
        // if($createpassword !== $confirmpassword){
        //     $_SESSION['register'] = 'Password did not match';
        // }else{
        //     $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
        // }           

        if($_SESSION['register']){
            $_SESSION['register-data'] = $_POST;
            header('Location: register.php');
            die();
        }else{
            $insertUser_query = "INSERT INTO users (`username`, `password`, `email`) VALUES ('$username', '$createpassword', '$email')";
            $insert_data = $conn->query($insertUser_query) or die ($conn->error);
            
            $_SESSION['register'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-check success"></i>
                                            <p>User has been registered successfully</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
            header('Location: register.php');
            die();
        }

    }else{
        header('Location: register.php');
        die();
    }
?>
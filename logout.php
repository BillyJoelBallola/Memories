<?php 

    session_start();
    unset($_SESSION['userLogin']);
    unset($_SESSION['userId']);
    unset($_SESSION);
    header("Location: login.php");
    
?>
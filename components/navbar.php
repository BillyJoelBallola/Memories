<?php
    
    // if(!isset($_SESSION['userLogin'])){
    //     header("Location: login.php");
    // }

    $username = $_SESSION['userLogin'] ?? null;

?>

<nav>
    <div class="container nav-container">
        <div class="nav-logo">
            <img src="assets/logo.png" alt="memories logo">
        </div>
        <ul class="nav-links">
            <?php if($username) {?>
                <li><a href="index.php">Home</a></li>
                <li><a href="myMemories.php">My memories</a></li>
                <li><a href="write.php">Write</a></li>
                <div>
                    <a href="myAccount.php"><?php echo $username ?></a>
                    <a href="logout.php" class="nav-logout">Logout</a>
                </div>
            <?php }else {?>
                <div class="no-username">
                    <a href="login.php">Login</a>
                </div>
            <?php }?>
        </ul>

         <!-- mobile view -->
        <?php if($username) {?>
            <div class="username">
                <a href="myAccount.php"><?php echo $username ?></a>
            </div>
        <?php } else {?>
            <div class="username">
                <a href="login.php">Login</a>
            </div>
        <?php } ?>

        <div class="nav-links-mb blur-bg">
            <a href="index.php"><i class="fa-solid fa-house"></i></a>
            <a href="myMemories.php"><i class="fa-solid fa-book"></i></a>
            <a href="write.php"><i class="fa-solid fa-pen"></i></a>
            <?php if($username) {?>
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
            <?php } else {?>
                
            <?php } ?>
        </div>
    </div>
</nav>
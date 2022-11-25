<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['userLogin'])){
        header("Location: login.php");
    }

    $username = $_SESSION['userLogin'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="assets/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="style/general.css">
    
    <!-- <script defer src="javascript/loader.js"></script> -->
    <script defer src="https://kit.fontawesome.com/32dee845d7.js" crossorigin="anonymous"></script>

    <title>Memories</title>
</head>
<body>
    <!-- <?php include('components/loader.php') ?> -->
    <?php include('components/navbar.php') ?>
    <main>
        <section id="hero">
            <div class="container hero-container">
                <div class="hero-content">
                    <img src="assets/hero-img.png" alt="forest with house">
                </div>
            </div>
        </section>
        <section class="bg-green">
            <div class="container about-home-container">
                <div class="about-home-content">
                    <div class="about-home-text">
                        <h2>About</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda dignissimos voluptate animi at eaque amet dolore labore aspernatur rerum saepe ad quasi fugiat nobis est voluptas, molestiae distinctio corporis neque perspiciatis totam, porro necessitatibus nisi. Quod, delectus nam. Voluptatibus voluptates quos commodi ab animi nihil inventore illum sit perspiciatis minima!</p>
                        <a href="#" class="btn">learn more</a>
                    </div>
                    <div class="about-home-img">
                        <img src="assets/home-img2.png" alt="forest with house">
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container write-home-container">
                <div class="write-home-content">
                    <div class="write-home-img">
                        <img src="assets/home-img.png" alt="forest with house">
                    </div>
                    <div class="write-home-text">
                        <h2>Start Writing Now!</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda dignissimos voluptate animi at eaque amet dolore labore aspernatur rerum saepe ad quasi fugiat nobis est voluptas, molestiae distinctio corporis neque perspiciatis totam, porro necessitatibus nisi. Quod, delectus nam. Voluptatibus voluptates quos commodi ab animi nihil inventore illum sit perspiciatis minima!</p>
                        <a href="write.php" class="btn">Start now</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="contact">
            <div class="container contact-home-container">
                <div class="contact-home-content">
                    <div class="contact-home-img">
                        <img src="assets/team.png" alt="forest with house">
                    </div>
                    <!-- desktop view -->
                    <div class="contact-floating-content">
                        <div class="contact-home-text pos-left">
                            <h3>Hello <?php echo $username ?>! Welcome to Memories👋</h3>
                        </div>
                        <div class="contact-home-text pos-right">
                            <p>I hope that you enjoy using our website. We are the creator of Memories Diary Website, so if you have concern, problem or you just want to talk, feel free to contact us through our social media accounts.</p>
                        </div>
                        <div class="contact-home-text pos-low">
                            <ul class="contact-social-media">
                                <li><a href="#"><i class="fa-brands fa-facebook-messenger"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-solid fa-envelope"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- mobile view -->
                    <div class="contact-home-content-mb">
                        <div class="contact-home-text-mb">
                            <h3>Hello <?php echo $username ?>! Welcome to Memories👋</h3>
                            <p>I hope that you enjoy using our website. We are the creator of Memories Diary Website, so if you have concern, problem or you just want to talk, feel free to contact us through our social media accounts.</p>
                            <ul class="contact-social-media">
                                <li><a href="#"><i class="fa-brands fa-facebook-messenger"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-solid fa-envelope"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include('components/footer.php') ?>
</body>
</html>
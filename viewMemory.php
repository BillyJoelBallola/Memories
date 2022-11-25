<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    require('dbConnect.php');
    $conn = connection();

    $memoryId = $_GET['id'];

    $getMemoryById_query = "SELECT * FROM memory WHERE id = '$memoryId'";
    $data = $conn->query($getMemoryById_query) or die ($conn->error);
    $row = $data->fetch_assoc(); 
    
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

    <title>Memory</title>
</head>
<body>
    <div class="view-bg" style="background:<?= $row['colorTheme']?>">
        <div class="view-container">
            <div class="view-control">
                <div>
                    <a href="myMemories.php">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h1><?= $row['title'] ?></h1>
                </div>
                <div>
                    <?= $row['datetime'] ?>
                </div>
            </div>
            <div class="view-content">
                <div class="view-text">
                    <?php if($row['image']){ ?> 
                        <div>
                            <img src="uploads/<?= $row['image'] ?>" alt="memory-image">
                        </div>
                    <?php } else {?>
                        <div></div>
                    <?php }?>
                    <p class="text"><?= nl2br($row['content']) ?></p>
                </div>
            </div>
        </div>
    </div>  
</body>
</html>
<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['userLogin'])){
        header('Location: login.php');
    }
    
    require('dbConnect.php');
    $conn = connection();

    $getAllMemory_query = "SELECT m.id, u.username, m.title, m.content, m.colorTheme, m.image, m.datetime FROM users u JOIN memory m ON u.id=m.uid WHERE m.uid =". $_SESSION['userId'] ."";
    $data = $conn->query($getAllMemory_query) or die ($conn->error);
    $row = $data->fetch_assoc();
    $result = $data->num_rows;

    function truncated($string, $n){
        return strlen($string) > $n ? substr($string, 0, $n).'...' : $string;
    }
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
    
    <title>Memories | My Memories</title>
</head>
<body>
    <?php include('components/navbar.php') ?>
    <?php if(isset($_SESSION['editMemory'])): ?>
        <?= $_SESSION['editMemory']; 
            unset($_SESSION['editMemory']);
        ?>
    <?php endif ?>
    <?php if(isset($_SESSION['deleteMemory'])): ?>
        <?= $_SESSION['deleteMemory']; 
            unset($_SESSION['deleteMemory']);
        ?>
    <?php endif ?>
    <div class="container myMemories-container">
        <div class="myMemories-wrapper">
            <?php  if ($result > 0){ ?>
                <?php do { ?>
                    <div class="memory-container" style="background: <?php echo $row['colorTheme']?>">
                        <div class="memory-header">
                            <a href="viewMemory.php?id=<?php echo $row['id']?>">
                                <h3><?php echo $row['title'] ?></h3>
                            </a>
                            <div class="memory-control">
                                <div class="edit">
                                    <a href="editMemory.php?id=<?php echo $row['id'] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                                <div class="delete">
                                    <a href="deleteMemory.php?id=<?php echo $row['id'] ?>">
                                        <i class="fa-solid fa-eraser"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <small><?php echo $row['datetime']?></small>
                        <div class="mermory-content">
                            <p><?php echo truncated($row['content'], 150) ?></p>
                        </div>
                    </div>
                <?php }while($row = $data->fetch_assoc()) ?>
            <?php } else {?>
                <span>No memory yet! Start writing now.</span>
            <?php }?>
        </div>
    </div>
    <!-- <?php include('components/footer.php') ?> -->
</body>
</html>
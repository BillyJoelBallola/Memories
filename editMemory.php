<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    require('dbConnect.php');
    $conn = connection();

    $memoryId = $_GET['id'];
    $theme_clr = array('#CEFAD2','#FFD0D0', '#D7ECFF', '#FFFDD3', '#FFE7D9', '#F0E1FF');

    $getById_query = "SELECT * FROM memory WHERE id = '$memoryId'";
    $data = $conn->query($getById_query) or die ($conn->error);
    $row = $data->fetch_assoc();

    if(isset($_POST['update'])){
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clr = $_POST['clr'];

        if(empty($title)){
            $_SESSION['editMemory'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Title cannot be empty</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }elseif(empty($content)){
            $_SESSION['editMemory'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Content cannot be empty</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }

        if($_SESSION['editMemory']){
            header('Location: editMemory.php?id='.$memoryId);
            die();
        }else{
            $insertMemory_query = "UPDATE `memory` SET `title` = '$title', `content` = '$content', `colorTheme` = '$clr' WHERE id = '$memoryId'";
            $conn->query($insertMemory_query) or die ($conn->error);

            $_SESSION['editMemory'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-check success"></i>
                                            <p>Memory updated successfully</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
                                        
            header('Location: myMemories.php');
            die();
        }
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
    <script defer src="javascript/theme.js"></script>
    <script defer src="javascript/msgBox.js"></script>

    <title>Memories | Edit</title>
</head>
<body>
    <?php include('components/navbar.php') ?>
    <?php if(isset($_SESSION['editMemory'])): ?>
        <?= $_SESSION['editMemory']; 
            unset($_SESSION['editMemory']);
        ?>
    <?php endif ?>
    <div class="container write-content">
        <div class="form-container" style="background: <?php echo $row['colorTheme'] ?>">
            <form method="POST" id="memory-form" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Input title of your memory here..." value="<?= $row['title']?>">
                <div></div>
                <textarea name="content" cols="30" rows="20" placeholder="Input content of your memory here..."><?= $row['content']?></textarea>
            </form>
        </div>     
        <div class="control-container">
            <div>
                <h4>Theme</h4>
                <div class="clr-theme">
                    <?php foreach($theme_clr  as $clr){ ?>
                        <div class="clr-bg-color" style="background:<?php echo $clr?>">
                            <input
                                style="background:<?php echo $clr?>"
                                value="<?php echo $clr?>"
                                type="radio"
                                id="clr-btn"
                                name="clr"
                                form="memory-form">
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div>
                <h4>Image</h4>
                <div>
                    <img class="edit-image" src="uploads/<?php echo $row['image'] ?>" alt="memory_img">
                    <!-- <input type="file" name="memory_img" form="memory-form"> -->
                </div>
            </div>
            <input type="submit" class="btn save-btn" name="update" value="Update" form="memory-form">
        </div>      
    </div>
    <?php include('components/footer.php') ?>
</body>
</html>


<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    require('dbConnect.php');
    $conn = connection();

    $memoryId = $_GET['id'];
    $theme_clr = array('#CEFAD2','#FFD0D0', '#D7ECFF', '#FFFDD3', '#FFE7D9', '#F0E1FF', '#D6E4E5', '#8D9EFF', '#CDFCF6', '#E1CEB5', '#9ED5C5', '#5F9DF7', '#FFA1CF', '#C8DBBE', '#7FBCD2');

    $getById_query = "SELECT * FROM memory WHERE id = '$memoryId'";
    $data = $conn->query($getById_query) or die ($conn->error);
    $row = $data->fetch_assoc();

    if(isset($_POST['removeImg'])){
        unlink("./uploads/".$row['image']); 

        $deleteImg_query = "UPDATE `memory` SET `image` = '' WHERE `id` = '$memoryId'";
        $conn->query($deleteImg_query) or die ($conn->error);

        header('Location: editMemory.php?id='.$memoryId);
    }

    if(isset($_POST['update'])){
        $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
        $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
        $currentImg = $_POST['current_memory_img']; 
        $clr = $_POST['clr'];

        $newImage = $_FILES['memory_img'];

        $img_name = $newImage['name'];
        $img_size = $newImage['size'];
        $tmp_name = $newImage['tmp_name'];
        $error = $newImage['error'];

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
        
        if($img_name){
            if($img_size > 1000000){
                $_SESSION['editMemory'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Image size too large</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
            }else{
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allow_exs = array("jpg", "jpeg", "png");

                if(in_array($img_ex_lc, $allow_exs)){

                    if($currentImg){
                        unlink("./uploads/".$currentImg); 
                    }

                    $new_img_name = uniqid("Memories-", true).'.'.$img_ex_lc;
                    $img_upload_path = 'uploads/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    
                }else{
                    $_SESSION['editMemory'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Invalid image file type</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
                }
            }   
        }
        
        if($_SESSION['editMemory']){
            header('Location: editMemory.php?id='.$memoryId);
            die();
        }else{
            $memory_image = $new_img_name ? $new_img_name : $currentImg;
            $insertMemory_query = "UPDATE `memory` SET `title` = '$title', `content` = '$content', `colorTheme` = '$clr', `image` = '$memory_image' WHERE id = '$memoryId'";
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
                <div class="edit-control">
                    <h4>Image</h4>
                    <?php if($row['image']) {?>
                        <input type="submit" class="remove-btn" name="removeImg" value="Remove Image" form="remove-img">
                    <?php } ?>
                </div>
                <div>
                    <?php if($row['image']) {?>
                        <img class="edit-image" src="uploads/<?= $row['image'] ?>" alt="memory image">
                        <input type="hidden" value="<?= $row['image'] ?>" name="current_memory_img" form="memory-form">
                    <?php } ?>
                    <input type="file" name="memory_img" form="memory-form">
                </div>
            </div>
            <input type="submit" class="btn" name="update" value="Update" form="memory-form">
        </div>      
    </div>
    <form method="POST" id="remove-img"></form>
    <?php include('components/footer.php') ?>
</body>
</html>


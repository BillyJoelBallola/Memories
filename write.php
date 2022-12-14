<?php 

    if(!isset($_SESSION)){
        session_start();
    }
    
    if(!isset($_SESSION['userLogin'])){
        header('Location: login.php');
    }

    $theme_clr = array('#CEFAD2','#FFD0D0', '#D7ECFF', '#FFFDD3', '#FFE7D9', '#F0E1FF', '#D6E4E5', '#8D9EFF', '#CDFCF6', '#E1CEB5', '#9ED5C5', '#5F9DF7', '#FFA1CF', '#C8DBBE', '#7FBCD2');

    $title = $_SESSION['write-data']['title'] ?? null;
    $content = $_SESSION['write-data']['content'] ?? null;
    $clr = $_SESSION['write-data']['clr'] ?? null;

    unset($_SESSION['write-data']);
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
    <script defer src="javascript/controls.js"></script>

    <title>Memories | Write</title>
</head>
<body>
    <?php include('components/navbar.php') ?>
    <?php if(isset($_SESSION['write'])): ?>
        <?= $_SESSION['write']; 
            unset($_SESSION['write']);
        ?>
    <?php endif ?>
    <div class="container write-content">
        <div class="form-container" style="background: #CEFAD2">
            <form action="write-logic.php" method="POST" id="memory-form" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Input title of your memory here..." value="<?= $title ?>">
                <div></div>
                <textarea name="content" cols="30" rows="20" placeholder="Input content of your memory here..."><?= $content ?></textarea>
            </form>
        </div>     
        <div>
            <div class="control-container">
                <div>
                    <h4>Theme</h4>
                    <div class="clr-theme">
                        <?php foreach($theme_clr  as $clr){ ?>
                            <div class="clr-bg-color" style="background:<?= $clr?>">
                                <input
                                    style="background:<?= $clr?>"
                                    value="<?= $clr?>"
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
                        <input type="file" name="memory_img" form="memory-form">
                    </div>
                </div>
                    <input type="submit" class="btn save-btn" name="save" value="save" form="memory-form">
                </div>
            </div>   
            <!-- mobile view -->
            <div class="control-mb">
                <div class="flex">
                    <button class="control-btn ctrl">Controls</button>
                    <input type="submit" class="ctrl" name="save" value="Save" form="memory-form">
                </div>
                <div class="control-container-mb">
                    <div>
                        <h4>Theme</h4>
                        <div class="clr-theme">
                            <?php foreach($theme_clr  as $clr){ ?>
                                <div class="clr-bg-color" style="background:<?= $clr?>">
                                    <input
                                        style="background:<?= $clr?>"
                                        value="<?= $clr?>"
                                        type="radio"
                                        id="clr-btn_mb"
                                        name="clr"
                                        form="memory-form">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div>
                        <h4>Image</h4>
                        <div>
                            <input type="file" name="memory_img-mb" form="memory-form">
                        </div>
                    </div>
                        <!-- <input type="submit" class="btn save-btn" name="save" value="save" form="memory-form"> -->
                    </div>
                </div>
            </div>
        </div>
    <?php include('components/footer.php') ?>
</body>
</html>


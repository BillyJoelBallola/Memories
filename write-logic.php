<?php 

    if(!isset($_SESSION)){
        session_start();
    }
    
    require('dbConnect.php');
    $conn = connection();

    $userId = $_SESSION['userId'];

    if(isset($_POST['save'])){
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clr = $_POST['clr'];

        $img_name = $_FILES['memory_img']['name'];
        $img_size = $_FILES['memory_img']['size'];
        $tmp_name = $_FILES['memory_img']['tmp_name'];
        $error = $_FILES['memory_img']['error'];

        $new_img_name = '';

        if(empty($title)){
            $_SESSION['write'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Title cannot be empty</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }elseif(empty($content)){
            $_SESSION['write'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Content cannot be empty</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
        }elseif($error === 0){
            if($img_size > 1000000){
                $_SESSION['write'] = '<div class="msgBox">
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
                    $new_img_name = uniqid("Memories-", true).'.'.$img_ex_lc;
                    $img_upload_path = 'uploads/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                }else{
                    $_SESSION['write'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-exclamation error"></i>
                                            <p>Invalid image file type</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';
                }
            }
        }

        if(isset($_SESSION['write'])){
            $_SESSION['write-data'] = $_POST;
            header('Location: write.php');
            die();
        }else{
            $insertMemory_query = "INSERT INTO `memory`(`title`, `content`, `colorTheme`, `image`, `uid`) VALUES ('$title', '$content', '$clr', '$new_img_name', '$userId')";
            $conn->query($insertMemory_query) or die ($conn->error);

            $_SESSION['write'] = '<div class="msgBox">
                                        <div>
                                            <i class="fa-solid fa-circle-check success"></i>
                                            <p>Memory has been save successfully</p>
                                        </div>
                                        <span class="msgBox-close">&times;</span>
                                    </div>';

            header('Location: write.php');
            die();
        } 

    }else{
        header('Location: write.php');
        die();
    }
?>
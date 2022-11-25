<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    require('dbConnect.php');
    $conn = connection();

    $getAll_query = "SELECT * FROM memory WHERE id =".$_GET['id'];
    $data = $conn->query($getAll_query) or die ($conn->error);
    $row = $data->fetch_assoc();
    $total = $data->num_rows;

    if($total != 0){
        do{
            $filename = $row['image'];
        }while($row = $data->fetch_assoc());
    }
    
    unlink("./uploads/".$filename); 
    $deleteMemory_query = "DELETE FROM memory WHERE id =". $_GET['id'];
    $conn->query($deleteMemory_query) or die ($conn->error);
    
    $_SESSION['deleteMemory'] = '<div class="msgBox">
                                <div>
                                    <i class="fa-solid fa-circle-check success"></i>
                                    <p>Memory deleted successfully</p>
                                </div>
                                <span class="msgBox-close">&times;</span>
                            </div>';
                                    
    header('Location: myMemories.php');

?>
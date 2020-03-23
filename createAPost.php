<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create a Post</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/templateStyling.css">
        <link rel="stylesheet" href="css/createApost.css">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
    </head>
    <body>
       <?php 
    include 'db_connection.php';
    include 'header.php';

    if(isset($_POST['submit'])){
        $postTitle = $_POST['title'];
        $description = $_POST['description'];
        $link = $_POST['link'];
        $topic = $_POST['chat'];
        $todays_date = date("Y-m-d");
        $author = $_SESSION['username'];
        $defaultPhoto = TRUE;
        $file = $_FILES['pic'];
        $fileDestination = '';
        if ( ! empty($_FILES)) {
        $allowed = array('jpg','jpeg','png');
        $file_Name=$_FILES['pic']['name'];
        $file_Temp_Name=$_FILES['pic']['tmp_name'];
        $file_Error=$_FILES['pic']['error'];
        $file_Size=$_FILES['pic']['size'];
        $file_Type=$_FILES['pic']['type'];
        
        $file_ext = explode('.', $file_Name );
        $fileActualExt = strtolower(end($file_ext));
        if (in_array($fileActualExt, $allowed)){
            if($file_Error===0){
                if ($file_Size < 10000000){
                    $file_New_Name = uniqid('',true).".".$fileActualExt;
                    $fileDestination = 'images/post_pictures/'.$file_New_Name;
                    move_uploaded_file($file_Temp_Name,$fileDestination);
                    $defaultPhoto = FALSE;
                }
                else {
                    echo "<script type='text/javascript'>alert('File size too large');</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('Error uploaded picture');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Error uploaded picture, must be a jpg, jpeg, or png');</script>";
        }
        }
        
        echo $postTitle;
        echo $description;
        echo $link;
        echo $topic;
        echo $todays_date;
        echo $fileDestination;

    }

    ?>

        <div id="main">
            <form method="POST" action="createAPost.php" class="holder" enctype="multipart/form-data">
                <h1>Create a post</h1>
                <div id="chats">
                <label>Chat:</label>
                <select name="chat" >
                    <option selected>Dogs</option>
                    <option>Cats</option>
                    <option>Subarus</option>
                    <option>Off-topic</option>
                </select>
                </div>
                <input type="text" required name="title" placeholder="Enter title">
                <textarea required name="description" rows="3" cols="50" placeholder="Enter post description"></textarea>
                <input type="text" name="link" placeholder="(optional) Enter a link">
                <div id="image">
                    <label>(Optional, upload an image)</label>
                    <input type="file" id="img" name="pic" accept="image/*">
                </div> 
                <div id="buttons">
                    <input type="submit" name="submit" value="Submit Post">
                    <input type="reset" value="clear all">  
                </div>
            </form>
        </div>

    </body>
</html>
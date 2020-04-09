<!DOCTYPE html>
<html>
    <head>
        <title>Lorem Ipsum</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/templateStyling.css">
        <link rel="stylesheet" href="css/postStyling.css"> <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script type="text/javascript"> window.jQuery || document.write('<script src="js/jquery-3.1.1.min.js"><\/script>'); </script>
        <script src="js/commentReply.js"></script>
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
        
    </head>
    <body>

    <?php
    include 'db_connection.php';
	include 'header.php';
    
    $conn = OpenCon();
    //the feed.php page sends over the postID of the clicked post
    if(isset($_GET["postId"])){
        $postid = $_GET["postId"];
       
    }
    //if there is an error some how renavigate to badNav page
    else {
        header("Location: badNavigation.html");
        exit();
    }
    //collect all the details required for the post
    $query = "SELECT * FROM posts WHERE post_id = '$postid'";
    $result = $conn->query($query);

	if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
			$title = $row["title"];
			$author = $row["author"];
            $topic = $row["topic"];
            $date = $row["date"];
            $content = $row["content"];
            $imagePath = $row["image_path"];
            switch ($row["avg_rating"]) {
                case 0:
                    $path = "images/star0.png";
                    break;
                case 1:
                    $path = "images/star1.png";
                    break;
                case 2:
                    $path = "images/star2.png";
                    break;
                case 3:
                    $path = "images/star3.png";
                    break;
                case 4:
                    $path = "images/star4.png";
                    break;
                case 5:
                    $path = "images/star5.png";
                    break;
                default:
                    $path = "images/star5.png";
            }
    } 
    else {
		echo "0 results";
    }
    CloseCon($conn);

    ?>
    <!-- using the php var, and without changing structure of the HTML just inject the information needed to populate posts -->
    
        <div id="main">

            <div id="heading">
              <?php echo "<h2 id='title'>".$title." </h2>";  ?> 
                <span id="starGroup">
                <?php echo "<img class='stars' src='".$path."'"; ?>
                </span>
            </div>

            <div id="metadata">
                <?php echo "<p> chats/ ".$topic."</p>"; ?>
                <?php echo "<p>Posted by: ".$author."</p>"; ?>
                <?php echo "<p>Posted on: ".$date."</p>"; ?>
            </div>
            <div id="postbody">
        <?php
        if(!is_null($imagePath) ){
            echo "<img id='postImage' src='".$imagePath."'/>";

       
        }
        ?>
                <?php echo "<p id='postText'>".$content."</p>"; ?>

            </div>
        <?php
        //if the user is logged in, then the comment box will appear, otherwise it wont appear
        if(isset($_SESSION['username'])){
            echo "<div id='commentSection'>
            <h2>Comment Section</h2>
            <form id='commentForm' action='#' method='POST' >
            <label id='commentLabel'>Leave a comment below: </label>
            <textarea name='comment' id='commentBox'></textarea>
            <input type='submit' id='submitComment' name='submitButton'/>
            </form>";
         
        } 
        ?>
                <?php
                if(isset($_POST['submitButton'])){
                    $conn = OpenCon();
                       $username = $_SESSION['username'];
                       $commentSubmisssion = $_POST['comment'];
                       $dateTime = date('Y-m-d h:i:s a',time());
                       $postId = $_GET['postId'];
                       if(!empty($commentSubmisssion)){
                       $query = "INSERT INTO comments(post_id, content, date, author) VALUES ('$postId','$commentSubmisssion','$dateTime','$username')";
                       if($conn->query($query)){
                        
            
                    }
                    else {
                        echo ("Error: " .$conn->error);
                    }
                }
                        CloseCon($conn);
                }
                
                ?>
                <?php 
                //grab all the comments
                $conn = OpenCon();
                $query = "SELECT * FROM comments WHERE post_id ='$postid'";
                $result = $conn->query($query);
				CloseCon($conn);
				if ($result->num_rows > 0) {
					$i = 0;
					while ($row = $result->fetch_assoc()) {
                        $i++;
                        $commentContent = $row["content"];
                        $commentDate = $row["date"];
                        $commentAuthor = $row["author"];
                        $commentId = $row["comment_id"];
                        $commentParent = $row["parentId"];
                        //if they are a parent comment just post them like below
                        if ($commentParent==0){
                            echo "<article id=".$commentId." >
                            <p class='comment'>".$commentContent."</p>
                            <div class='commentInfo'>
                                <span class='commentSpan'>
                                <a href='#'><p class='userName'>By:".$commentAuthor."</p></a>
                                <p>on: ".$commentDate."</p>
                               <p class='reply' onClick='reply_click(this.id)' id=".$commentId.">Reply</p>
                                </span>
                            </div>
                        </article>";
                        }
                        //else if they are a reply comment, use the JS function to append it to the parent comment that they replied to
                        else {
                            echo "<script type='text/javascript'> jsfunction('$commentParent','$commentContent','$commentDate','$commentAuthor');</script>";
                         
                           
                        }

                   
                    }
                }
                ?>
                <?php
                //once they click submit reply, add their comment into the database
                if (isset($_POST["submitReply"])){
                    $dateTime = date('Y-m-d h:i:s a',time());
                    $username = $_SESSION['username'];
                    $replyContent = $_POST["reply"];
                    $parentId = $_POST["parentId"];
                    $postId=$_GET["postId"]; 
                    $conn = OpenCon();
                    if(!empty($replyContent)){

                    
                    $query = "INSERT INTO comments(post_id, content, date, author,parentId) VALUES ('$postId','$replyContent','$dateTime','$username','$parentId')";
                    if($conn->query($query)){

                    }
                    else {
                        echo ("Error: " .$conn->error);
                    }
                        CloseCon($conn);
                }
                }
                ?>

               
               
            </div>


        </div>

    </body>
</html>
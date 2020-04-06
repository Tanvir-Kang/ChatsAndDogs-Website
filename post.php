<!DOCTYPE html>
<html>
    <head>
        <title>Lorem Ipsum</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/templateStyling.css">
        <link rel="stylesheet" href="css/postStyling.css">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
        
    </head>
    <body>

    <?php
    include 'db_connection.php';
	include 'header.php';
    
    $conn = OpenCon();
    $postid = 2;
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

            <div id="commentSection">
                <h2>Comment Section</h2>
                <?php 
                $conn = OpenCon();
                $query = "SELECT * FROM comments WHERE post_id ='$postid'";
                $result = $conn->query($query);
				CloseCon($conn);
				if ($result->num_rows > 0) {
					$i = 0;
					while ($row = $result->fetch_assoc()) {
                        $commentContent = $row["content"];
                        $commentDate = $row["date"];
                        $commentAuthor = $row["author"];
                        $commentRating = $row["avg_rating"];

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

                    echo "<article>
                    <p class='comment'>".$commentContent."</p>
                    <div class='commentInfo'>
                        <span class='commentSpan'>
                        <a href='#'><p class='userName'>By:".$commentAuthor."</p></a>
                        <p>on: ".$commentDate."</p>
                        <img class='commentRating' src='".$path."'/>
                        <p class='reply'>Reply<p>
                        </span>
                    </div>
                </article>
                        ";
                    }
                }
                ?>
                

                <article class="reply">
                <p class="subComment">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis, nulla congue auctor ullamcorper, ante mauris pharetra tortor, ut viverra tellus mi vitae ipsum. Mauris</p>
                <div class="commentInfo">
                    <a href="#"><p class="userName">By: Zeebra</p></a>
                    <p>on: 2020-02-17</p>
                    
                </div>
                </article>
               
            </div>


        </div>

    </body>
</html>
<?php
session_start();
if (!isset($_SESSION['login'])) {  // Check if logged in
    header("Location: badNavigation.html"); // If not logged in, redirect
    exit();
}
session_abort();
?>
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
    $editing = false;
    if (isset($_GET['postId'])) { // Check if admin/user is trying to edit post
        $editing = true;
        $originalId = $_GET['postId'];
        $query = "SELECT title, content, author, topic from posts where posts.post_id = " . $_GET["postId"];
        $conn = OpenCon();
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $originalTitle = $row["title"];
                $originalContent = $row["content"];
                $originalAuthor = $row["author"];
                $originalTopic = $row["topic"];
            }
        }
        CloseCon($conn);
        if ($_SESSION['admin'] == false && $_SESSION['username'] != $originalAuthor) // Check if user is original author or admin
            echo "<script>window.location.href = 'badNavigation.html'</script>";  // Redirect if not
    }
    if (isset($_POST['editingId'])) { // Check if editing when sending new post
        $originalId = $_POST['editingId'];
        $editing = true;
        $originalAuthor = $_POST['originalAuthor'];
    }

    if (isset($_POST['submit'])) {
        $postTitle = $_POST['title'];
        $description = $_POST['description'];
        $link = $_POST['link'];
        $topic = $_POST['chat'];
        $topic = strtolower($topic);
        if ($topic == "advice")
            $topic = "dogs";
        $todays_date = date("Y-m-d");
        $author = $_SESSION['username'];
        if ($editing == true)
            $author = $originalAuthor;
        $file = $_FILES['pic']['tmp_name'];
        $fileDestination = NULL;
        $content = $description . " " . $link;

        if (is_uploaded_file($file)) {

            $allowed = array('jpg', 'jpeg', 'png');
            $file_Name = $_FILES['pic']['name'];
            $file_Temp_Name = $_FILES['pic']['tmp_name'];
            $file_Error = $_FILES['pic']['error'];
            $file_Size = $_FILES['pic']['size'];
            $file_Type = $_FILES['pic']['type'];
            $file_ext = explode('.', $file_Name);
            $fileActualExt = strtolower(end($file_ext));
            if (in_array($fileActualExt, $allowed)) {
                if ($file_Error === 0) {
                    if ($file_Size < 10000000) {
                        $file_New_Name = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = 'images/post_pictures/' . $file_New_Name;
                        move_uploaded_file($file_Temp_Name, $fileDestination);
                    } else {
                        echo "<script type='text/javascript'>alert('File size too large');</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Error uploaded picture');</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('Error uploaded picture, must be a jpg, jpeg, or png');</script>";
            }
        }


        if ($fileDestination === NULL) {
            $query = "INSERT into posts(title,content, topic, date,author) VALUES ('$postTitle','$content','$topic','$todays_date','$author')";
            if ($editing) // Check if currently editing post , Update if so.
                $query = "UPDATE posts SET title = '$postTitle', content = '$content', topic = '$topic' WHERE post_id = " . $originalId;
        } else {
            $query = "INSERT into posts(title,content, topic, date,author,image_path) VALUES ('$postTitle','$content','$topic','$todays_date','$author','$fileDestination')";
            if ($editing) // Check if currently editing post , Update if so.
                $query = "UPDATE posts SET title = '$postTitle', content = '$content', topic = '$topic', image_path = '$fileDestination' WHERE post_id = " . $originalId;
        }

        $conn = OpenCon();
        if ($conn->query($query)) {
            $_SESSION['postSuccess'] = true;
            echo "<script>window.location.href = 'feed.php'</script>"; // Set success and redirect
        } else {
            echo ("Error: " . $conn->error);
        }
        CloseCon($conn);
    }

    ?>

    <div id="main">
        <form method="POST" action="createAPost.php" class="holder" enctype="multipart/form-data">
            <h1>Create a post</h1>
            <div id="chats">
                <label>Topic:</label>
                <select name="chat">
                    <option <?php if ($editing) if ($originalTopic == "dogs") echo "selected"; ?>>Advice</option>
                    <option <?php if ($editing) if ($originalTopic == "chats") echo "selected";
                            if (!$editing) echo "selected"; ?>>Chats</option>
                </select>
            </div>
            <input type="text" required name="title" placeholder="Enter title" <?php if ($editing) echo "value='" . $originalTitle . "'"; ?>>
            <textarea required name="description" rows="3" cols="50" placeholder="Enter post description"><?php if ($editing) echo $originalContent; ?></textarea>
            <input type="text" name="link" placeholder="(optional) Enter a link">
            <?php if ($editing) echo '<input type="hidden" name="editingId" value="' . $originalId . '">
                                    <input type="hidden" name="originalAuthor" value="' . $originalAuthor . '">'; // Hidden entries to determine if new post or an edit
            ?>
            <div id="image">
                <label>(Optional)</label>
                <input type="file" id="img" name="pic" accept="image/*">
            </div>
            <div id="buttons">
                <input type="submit" name="submit" value="Submit Post">
                <input type="reset" value="Clear All">
            </div>
        </form>
    </div>

</body>

</html>
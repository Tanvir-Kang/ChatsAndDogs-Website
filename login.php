<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/templateStyling.css">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
    </head>
    <body>
    <?php
	include 'db_connection.php';
	include 'header.php';
    ?>
    <?php
    $conn = OpenCon();
    if(isset($_POST['username'])){
       $username = $_POST['username'];
       $password = $_POST['password'];
        echo $username;
        echo $password;
        $query = "SELECT * FROM users WHERE username='".$username."'AND password='".$password."' limit 1";
      
        $result = $conn->query($query);
        CloseCon($conn);
       
        if (!empty($result) && $result->num_rows > 0) {
            echo "You have logged in";
            echo "<script> window.location.assign('feed.php'); </script>";
            exit();
        }
        else {
            echo "Username or password does not match";
            echo "<script> window.location.assign('login.php'); </script>";
            exit();
        }
    }
    ?>
        <form method="POST" action="#" class="holder">
            <h1>Login</h1>
            <input required type="text" name="username" placeholder="Username" >
            <input required type="password" name="password" placeholder="Enter Password">
            <input type="submit" value="Login">

            <div id="links">
                <a href="#"><p>Forgot Password?</p></a>
                <a href="signup.html"><p>Don't have an account? Sign up now</p></a>
            </div>

        </form>


    </body>
</html>
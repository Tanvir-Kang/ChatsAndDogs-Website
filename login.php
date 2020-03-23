<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/templateStyling.css">
        <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script type="text/javascript"> window.jQuery || document.write('<script src="js/jquery-3.1.1.min.js"><\/script>'); </script>
        <script src="js/passwordRecovery.js"></script>
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
       
        $query = "SELECT * FROM users WHERE username='".$username."'AND password='".$password."' limit 1";
      
        $result = $conn->query($query);
        CloseCon($conn);
       
        if (!empty($result) && $result->num_rows > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['login'] = TRUE;
            echo "<script> window.location.assign('feed.php'); </script>";
            exit();
        }
        else {
            $message = "Username or password does not match";
            echo "<script type='text/javascript'>alert('$message');</script>";
            
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
                <a href="#" id ="forgotPassword" ><p>Forgot Password?</p></a>
                <a href="signup.php"><p>Don't have an account? Sign up now</p></a>
            </div>

        </form>

    <?php
    if(isset($_POST['recoverButton'])){
    $username = $_POST['uname'];

    $conn = OpenCon();
    $query = "SELECT email,password FROM users WHERE username='".$username."'";
    $result = $conn->query($query);
    CloseCon($conn);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $email = $row["email"];
            $password = $row["password"];
            require_once("PHPMailer/PHPMailerAutoload.php");
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '465';
            $mail->isHTML();
            $mail->Username = 'catsdogs262@gmail.com';
            $mail->Password = '123456Cats!';
            $mail->SetFrom('catsdogs262@gmail.com');
            $mail->Subject= 'Your Chats and Dogs password';
            $mail->Body = 'Hello, your chats and dogs password is the following: '.$password;
            $mail->AddAddress($email);
            $mail->Send();
        
        }
        
    }
    else{
        exit();
    }
    }
    ?>


    </body>
</html>
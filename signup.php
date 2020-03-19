<!DOCTYPE html>
<html>
    <head>
        <title>Make an Account</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/templateStyling.css">
        <link rel="stylesheet" href="css/signup.css">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
    </head>
    <body>
    <?php
	include 'db_connection.php';
    include 'header.php';
    $conn = OpenCon();
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $username = $_POST['userName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $birthday = $_POST['birthdate'];
        $gender = $_POST['gender'];
       
        $file = $_FILES['pic'];
       
        $file_Name=$_FILES['pic']['name'];
        $file_Temp_Name=$_FILES['pic']['tmp_name'];
        $file_Error=$_FILES['pic']['error'];
        $file_Size=$_FILES['pic']['size'];
        $file_Type=$_FILES['pic']['type'];

        $file_ext = explode('.', $file_Name );
        $fileActualExt = strtolower(end($file_ext));

        $allowed = array('jpg','jpeg','png');

        if (in_array($fileActualExt, $allowed)){
            if($file_Error===0){
                if ($file_Size < 10000000){
                    $file_New_Name = uniqid('',true).".".$fileActualExt;
                    $fileDestination = 'images/profile_pictures/'.$file_New_Name;
                    move_uploaded_file($file_Temp_Name,$fileDestination);
                    $query = "INSERT into users(username, first_name, age, sex, email, profile_pic_path, password) VALUES ('$username','$name','10','$gender','$email','$fileDestination','$password')";
                    if($conn->query($query)){
                    echo '<script>alert("success..Press okay to continue")</script>';
                    }
                    header("Location: login.php?uploadsuccess");
                }
                else {
                    echo "<script type='text/javascript'>alert('File size too large');</script>";
                }
            }
            else {
                echo "<script type='text/javascript'>alert('Error uploaded picture');</script>";
            }
        }
        else {
            echo "<script type='text/javascript'>alert('You may only upload jpg,jpeg, or png');</script>";
        }

        
    }
      
    ?>
   
        <form method="POST" class="holder" enctype="multipart/form-data">
            <h1>Sign Up</h1>
            <input type="text" required name="name" placeholder="First and last name">
            <input type="text" required name="userName" placeholder="Username" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$">
            <input type="email" required name="email" placeholder="Email">
            <input type="password" required name="password" placeholder="Pick a password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
            <label>Enter your birthdate:</label><input required type="date" name="birthdate">
            <div id="gender">
            <label>Gender:</label>
                <select required name="gender" >
                    <option>Male</option>
                    <option>Female</option>
                    <option>Non-binary</option>
                    <option selected></option>
                </select>
            </div>
            <div id="image">
                <label>Select a profile picture:</label>
                <input type="file" id="img" name="pic" accept="image/*">
            </div>
            <div id="buttons">
            <input type="submit" value="Sign Up" name="submit">
            <input type="reset" value="Clear">
            </div>  
            <div id="links">
               <a href="login.html"><p>Already have an account? sign in here</p></a> 
            </div>

        </form>
   
    </body>
</html>

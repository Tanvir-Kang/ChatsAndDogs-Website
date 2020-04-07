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
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/templateStyling.css">
    <link rel="stylesheet" href="css/styles.css">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
</head>

<body>
    <?php
    include 'db_connection.php';
    include 'header.php';
    $username = $_SESSION["username"]; // Get logged in user's username
    if (isset($_POST["fname"])) { // Check if save button was clicked
        $newFname = $_POST["fname"];
        $newLname = $_POST["lname"];
        if(strtolower($_POST["sex"]) == "male")
            $newSex = "M";
        else
            $newSex = "F";
        $newEmail = $_POST["email"];
        $newNumPets = $_POST["numPets"];
        $conn = OpenCon();
        $query = 'UPDATE users SET first_name = "'. $newFname.'", last_name = "'.$newLname.'", sex = "'.$newSex.'", email = "'.$newEmail.'", num_pets = '.$newNumPets.' WHERE username = "' . $username . '"';
        $conn->query($query); // Update database
        CloseCon($conn);
        echo "<script>    Swal.fire(
            'Success!',
            'Your profile has been edited.',
            'success'
        );</script>";
    }
    
    $conn = OpenCon();
    $query = 'SELECT first_name, last_name, sex, email, num_pets, profile_image_path FROM users WHERE username = "' . $username . '"';
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $fname = $row["first_name"];
            $lname = $row["last_name"];
            if ($row["sex"] == "M")
                $sex = "Male";
            else
                $sex = "Female";
            $email = $row["email"];
            $num_pets = $row["num_pets"];
            $image_path = $row["profile_image_path"];
        }
    }
    CloseCon($conn);
    ?>
    <article class="main">
        <div style="display:flex;justify-content:center;align-items:center;">
            <form method="post" action="editProfile.php">
                <label for="fname" class="editForm">First Name:</label><br>
                <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>"><br>
                <label for="lname" class="editForm">Last Name:</label><br>
                <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>">
                <label for="sex" class="editForm">Sex:</label>
                <select required name="sex">
                    <option <?php if (strtolower($sex) == "male") echo "selected"; ?>>Male</option>
                    <option <?php if (strtolower($sex) == "female") echo "selected"; ?>>Female</option>
                </select>
                <label for="email" class="editForm">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <label for="numPets" class="editForm">Number of Pets:</label><br>
                <input type="number" id="numPets" name="numPets" value="<?php echo $num_pets; ?>">
                <br><br><button type="button" onclick="location.href = 'profile.php'">Cancel</button> <input type="submit" value="Save">
            </form>
        </div>
    </article>
</body>

</html>
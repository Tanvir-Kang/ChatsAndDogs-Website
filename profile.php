<?php
session_start();
if (!isset($_SESSION['login'])) {  // Check if logged in
	header("Location: login.php"); // If not logged in, redirect
	exit();
}
session_abort();
?>
<!DOCTYPE html>
<html>

<head>
	<title>My Profile</title>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/templateStyling.css">
	<link rel="stylesheet" href="css/styles.css">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
</head>

<body>
	<?php
	include 'db_connection.php';
	include 'header.php';
	$username = $_SESSION["username"]; // Display their own profile by default
	$profileowner = true;
	if (isset($_GET["username"])) { // Check if user navigated through clicking a username
		$username = $_GET["username"]; // Display user that was navigated by
		$profileowner = false;
	}
	$conn = OpenCon();
	$query = 'SELECT first_name, last_name, age, sex, email, num_posts, COUNT(comment_id) as num_comments, num_pets, profile_image_path FROM users, comments WHERE username = "' . $username . '" AND author = "' . $username . '"';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) {
			$name = $row["first_name"] . " " . $row["last_name"];
			$age = $row["age"];
			if ($row["sex"] == "M")
				$sex = "Male";
			else
				$sex = "Female";
			$email = $row["email"];
			$num_posts = $row["num_posts"];
			$num_comments = $row["num_comments"];
			$num_pets = $row["num_pets"];
			$image_path = $row["profile_image_path"];
		}
	} else {
		echo "0 results";
	}
	?>
	<article class="main">
		<div id="info">
			<img id="ppicture" src="<?php echo $image_path; ?>" alt="Profile Picture">
			<br>
			<p class="attribute">
				<b>Name:</b> <?php echo $name; ?>
			</p>
			<br>
			<p class="attribute">
				<b>Age:</b> <?php echo $age; ?>
			</p>
			<br>
			<p class="attribute">
				<b>Sex:</b> <?php echo $sex; ?>
			</p>
			<br>
			<p class="attribute">
				<b>Email Address:</b> <?php echo $email; ?>
			</p>
			<br>
			<p class="attribute">
				<b>Number of Pets:</b> <?php echo $num_pets; ?>
			</p>
			<br>
			<p class="attribute">
				<b>Number of Posts:</b> <?php echo $num_posts; ?>
			</p>
			<br>
			<p class="attribute">
				<b>Number of Comments:</b> <?php echo $num_comments; ?>
			</p>
		</div>
		<div id="editPane">
			<?php
			if ($profileowner == true)
				echo '<button type="button" id="edit">
					Edit Profile
					</button>';
			?>

		</div>
		<div id="content">
			<h1 id="pHeading"><?php echo $username; ?></h1>
			<h2 class="cpHeading">My Comments</h2>
			<div class="comments">
				<ul class="commentLog">
					<?php
					$query = 'SELECT content FROM comments WHERE author = "' . $username . '"';
					$result = $conn->query($query);
					if ($result->num_rows > 0) {
						// output data of each row
						while ($row = $result->fetch_assoc()) {
							$content = substr($row["content"], 0, 36);
							if (strlen($row["content"]) > 33)
								$content = $content . "...";
							echo '<li class="commentItem">
							<a href="#"><p class="commentText">' . $content . '
							</p></a><img src="images/star2.png" class="postStars">
							</li>';
						}
					} else {
						echo "0 results";
					}
					?>
				</ul>
			</div>
			<h2 class="cpHeading">My Posts</h2>
			<div class="posts">
				<ul class="postLog">
					<?php
					$query = 'SELECT title FROM posts WHERE author = "' . $username . '"';
					$result = $conn->query($query);
					CloseCon($conn);
					if ($result->num_rows > 0) {
						// output data of each row
						while ($row = $result->fetch_assoc()) {
							$title = substr($row["title"], 0, 36);
							if (strlen($row["title"]) > 33)
								$title = $title . "...";
							echo '<li class="postItem">
							<a href="#"><p class="postText">' . $title . '
							</p></a><img src="images/star2.png" class="postStars">
							</li>';
						}
					} else {
						echo "<h2>0 results<h2>"; // TODO: Make this look nicer
					}
					?>
				</ul>
			</div>
		</div>
	</article>

</body>

</html>
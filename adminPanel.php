<?php
session_start();
if (isset($_SESSION['admin'])) {  // Check if admin and redirect if not
	if ($_SESSION["admin"] == false) {
		header("Location: badNavigation.html");
		exit();
	}
} else {
	header("Location: badNavigation.html");
	exit();
}
session_abort();
?>
<!DOCTYPE html>
<html>

<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/templateStyling.css">
	<link rel="stylesheet" href="css/styles.css">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<script type="text/javascript" src="js/adminPanel.js"></script>
</head>

<body>
	<?php
	include 'db_connection.php';
	include 'header.php';

	// Post deletion
	if (isset($_POST["postId"])) { // Check if post was selected for deletion
		$id = $_POST["postId"];
		$conn = OpenCon();
		$query = 'DELETE FROM posts WHERE posts.post_id = ' . $id;
		$conn->query($query);
		CloseCon($conn);
	}

	// User disabling/enabling
	if (isset($_POST["username"])) { // Check if user was selected for disabling/enabling
		$user = $_POST["username"];
		$conn = OpenCon();
		$query = 'UPDATE users SET enabled = !enabled WHERE username = "' . $user . '"';
		$conn->query($query);
		CloseCon($conn);
	}
	?>
	<article class="main">
		<h2 class="adminTitle">Admin Panel</h2>
		<h2 class="userWindow">Users<span class="userSearch">Search: <input type="text" placeholder="Name, Username or Email" id="userSearch" onkeyup="javascript:search(&quot;users&quot;)"> </span> </h2>
		<div class="userPort">
			<ul class="userList">
				<?php
				$conn = OpenCon();
				$query = 'SELECT username, profile_image_path, first_name, last_name, age, email, num_posts, enabled, COUNT(comments.comment_id) as num_comments, num_pets FROM users LEFT OUTER JOIN comments ON users.username = comments.author GROUP BY username';
				$result = $conn->query($query);
				if ($result->num_rows > 0) {
					// output data of each row
					while ($row = $result->fetch_assoc()) {
						$username = $row["username"];
						$name = $row["first_name"] . " " . $row["last_name"];
						$age = $row["age"];
						$email = $row["email"];
						$num_posts = $row["num_posts"];
						$num_comments = $row["num_comments"];
						$num_pets = $row["num_pets"];
						$image_path = $row["profile_image_path"];
						$toggle = "Enable";
						if ($row["enabled"] == 1)
							$toggle = "Disable";
						echo '					<div class="userEntry">
							<li class="user">
								<div class="details">
									<div class="disableUser">
										<a href = "javascript:;" onclick = "javascript:conf(this, &quot;' . $username . '&quot;);">' . $toggle . '</a>
									</div>
	
									<b>Name:</b> <span class = "searchTerm">' . $name . '</span>
									<br>
									<b>Email:</b> <span class = "searchTerm">' . $email . '</span>
									<br>
									<b>Age:</b> ' . $age . '
									<br>
									<b>Posts:</b> ' . $num_posts . '
									<br>
									<b>Comments:</b> ' . $num_comments . '
	
								</div>
								<div class="userRowGroup">
									<div class="userRow">
										<div class="username">
											<a href="#"><span class = "searchTerm">' . $username . '</span></a>
										</div>
									</div>
									<div class="imgRow">
										<div class="avatar">
											<img src="' . $image_path . '">
										</div>
									</div>
								</div>
							</li>
						</div>';
					}
				} else {
					echo "0 results";
				}
				?>
			</ul>
		</div>
		<h2 class="postWindow">Posts<span class="userSearch">Search: <input type="text" placeholder="Author(Username) or Post Title" id="postSearch" onkeyup="javascript:search(&quot;posts&quot;);"> </span> </h2>
		<div class="userPort">
			<ul class="userList">
				<?php
				$query = "SELECT title, posts.post_id, posts.num_ratings, posts.avg_rating, posts.date, posts.author, COUNT(comments.comment_id) as num_comments FROM posts LEFT OUTER JOIN comments ON posts.post_id = comments.post_id GROUP BY posts.post_id";
				$result = $conn->query($query);
				CloseCon($conn);
				if ($result->num_rows > 0) {
					// output data of each row
					while ($row = $result->fetch_assoc()) {
						$path = "";
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
								$path = "images/star0.png";
						}
						echo '							<div class="postEntry">
									<li class="adminPost">
										<div class="adminPostDetails">
											<div class="disablePost">
												<img src="' . $path . '">
												<br>
												<br>
												<a href = "javascript:;" onclick = "javascript:conf(this, &quot;' . $row["post_id"] . '&quot;);">Remove</a>
												<a href="#">Edit</a>
											</div> <b>Posted By:</b> <span class ="searchTerm">' . $row["author"] . '</span>
											<br>
											<b>Date:</b> ' . $row["date"] . '
											<br>
											<b>Comments:</b> ' . $row["num_comments"] . '
											<br>
											<b>Ratings:</b> ' . $row["num_ratings"] . '
										</div>
										<div class="userRowGroup">
											<div class="userRow">
												<div class="username">
													<a href="#"><span class = "searchTerm">' . $row["title"] . '</span></a>
												</div>
											</div>
										</div>
									</li>
								</div>';
					}
				} else {
					echo "0 results";
				}
				?>
			</ul>

		</div>
	</article>

</body>

</html>
<!DOCTYPE html>
<html>

<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/templateStyling.css">
	<link rel="stylesheet" href="css/styles.css">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
</head>

<body>
	<?php
	include 'db_connection.php';
	include 'header.php';
	?>
	<article class="main">
		<h2 class="adminTitle">Admin Panel</h2>
		<h2 class="userWindow">Users<span class="userSearch">Search: <input type="text" placeholder="Name, Email or Post Title" </span> </h2> <div class="userPort">
				<ul class="userList">
					<?php
					$conn = OpenCon();
					$query = 'SELECT username, first_name, last_name, age, email, num_posts, num_comments, num_pets FROM users';
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
							echo '					<div class="userEntry">
							<li class="user">
								<div class="details">
									<div class="disableUser">
										<a href="#">Disable</a>
									</div>
	
									<b>Name:</b> ' . $name . '
									<br>
									<b>Email:</b> ' . $email . '
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
											<a href="#">' . $username . '</a>
										</div>
									</div>
									<div class="imgRow">
										<div class="avatar">
											<img src="images/img_avatarf.png">
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
				<h2 class="postWindow">Posts<span class="userSearch">Search: <input type="text" placeholder="Author or Post Title" </span> </h2> <div class="userPort">
						<ul class="userList">
							<?php
							$query = "SELECT title, num_ratings, avg_rating, date, author, num_comments FROM posts";
							$result = $conn->query($query);
							CloseCon($conn);
							if ($result->num_rows > 0) {
								// output data of each row
								while ($row = $result->fetch_assoc()) {
									echo '							<div class="userEntry">
									<li class="adminPost">
										<div class="adminPostDetails">
											<div class="disablePost">
												<img src="images/star0.png">
												<br>
												<br>
												<a href="#">Remove</a>
												<a href="#">Edit</a>
											</div> <b>Posted By:</b> '.$row["author"].'
											<br>
											<b>Date:</b> '.$row["date"].'
											<br>
											<b>Comments:</b> '.$row["num_comments"].'
											<br>
											<b>Ratings:</b> '.$row["num_ratings"].'
										</div>
										<div class="userRowGroup">
											<div class="userRow">
												<div class="username">
													<a href="#">'.$row["title"].'</a>
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
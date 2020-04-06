<!DOCTYPE html>
<html>

<head>
	<title>Chats &amp; Dogs Feed</title>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/templateStyling.css">
	<link rel="stylesheet" href="css/styles.css">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/feed.js"></script>
	<script type="text/javascript">
		window.jQuery ||
			document.write('<script src="js/jquery-3.1.1.min.js"><\/script>');
	</script>
</head>

<body>
	<?php
	include 'db_connection.php';
	include 'header.php';

	?>

	<!--This section is utilized in sorting of the posts. -->
	<form method="get" id="toprated" action="feed.php">
		<input type="hidden" name="orderBy" value="top-rated">
	</form>
	<form method="get" id="newest" action="feed.php">
		<input type="hidden" name="orderBy" value="newest">
	</form>
	<form method="get" id="oldest" action="feed.php">
		<input type="hidden" name="orderBy" value="oldest">
	</form>
	<form method="get" id="mostratings" action="feed.php">
		<input type="hidden" name="orderBy" value="most-ratings">
	</form>
	<form method="get" id="hot" action="feed.php">
		<input type="hidden" name="orderBy" value="hot">
	</form>
	<?php
	if (!isset($_GET["orderBy"])) // Check if sorting method has been selected
		$sortMethod = "newest"; // Default to newest
	else
		$sortMethod = $_GET["orderBy"]; // Otherwise get value
	if (isset($_POST["rating"])) { // Check if the user attempted to rate a post
		echo "<script> ratingFailed(); </script>";
		if (isset($_SESSION["login"])) { // If user is logged in
			$rating = $_POST["rating"];
			$postId = $_POST["postId"];
			$username = $_SESSION["username"];
			$conn = OpenCon();
			$query = 'SELECT FROM ratings WHERE ratings.user = ' . $username . ' AND ratings.postId = ' . $postId;
			$result = $conn->query($query);
			if ($result->num_rows > 0) // If result is not empty
				echo "<script> ratingFailed(); </script>"; // User has already rated the post
			else {
				$query = "INSERT INTO ratings (post_id, user, rating) VALUES (" . $postId . ", " . $username . ", " . $rating . ")";
				$conn->query($query); // Insert rating
				echo "<script> ratingSucceed(); </script>";
			}

			CloseCon($conn);
		}
	}
	?>

	<article class="main">
		<div class="topbar">
			<select id="sort" onchange="javascript:sort()">
				<option value="topRated" <?php if ($sortMethod == "top-rated") echo 'selected'; ?>>Top-Rated</option>
				<option value="newest" <?php if ($sortMethod == "newest") echo 'selected'; ?>>Newest</option>
				<option value="oldest" <?php if ($sortMethod == "oldest") echo 'selected'; ?>>Oldest</option>
				<option value="mostRatings" <?php if ($sortMethod == "most-ratings") echo 'selected'; ?>>Most-Ratings</option>
				<option value="hot"<?php if ($sortMethod == "hot") echo 'selected'; ?>>Hot</option>
			</select>
			<!--End of section for sorting of the posts. -->
			<?php
			if (isset($_SESSION["login"]))
				if ($_SESSION["login"] == true) : // IF user is logged in, display create post button
			?>
				<a href="createAPost.php">
					<div class="createPost">Create Post</div>
				</a>
			<?php endif; ?>
			<div class="search"><img src="images/search.png"><input type="text" placeholder="Search" id="search" onkeyup="javascript:search()" /></div>
			<h2 id="feedHeader">Feed</h2>

		</div>
		<div class="feedPort">
			<ul class="feedPosts">
				<?php
				$conn = OpenCon();
				// Default
				//Switch for setting order for posts by clause for sql query
				$path = "";
				switch ($sortMethod) {
					case "top-rated":
						$clause = "ORDER BY posts.avg_rating DESC";
						break;
					case "newest":
						$clause = "ORDER BY posts.date DESC";
						break;
					case "oldest":
						$clause = "ORDER BY posts.date";
						break;
					case "most-ratings":
						$clause = "ORDER BY posts.num_ratings DESC";
						break;
					default:
						$clause = "ORDER BY posts.date DESC";
				}
				$query = "SELECT title, posts.post_id, posts.topic, posts.num_ratings, posts.avg_rating, posts.date, posts.author, COUNT(comments.comment_id) as num_comments FROM posts LEFT OUTER JOIN comments ON posts.post_id = comments.post_id GROUP BY posts.post_id " . $clause;
				$result = $conn->query($query);
				CloseCon($conn);
				if ($result->num_rows > 0) {
					// output data of each row
					$i = 0;
					while ($row = $result->fetch_assoc()) {
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
						} // Populate post feed
						$topic = "";
						if ($row["topic"] == "chats")
							$topic = "Chats";
						else if ($row["topic"] == "dogs")
							$topic = "Advice";

						echo '<li class="post" id = "' . $row["topic"] . '">
							<div class="titleRow">
								<div class="title">
									<form method="get" id="postLink' . $i . '" action="post.php">
									<input type="hidden" name="postId" value="' . $row["post_id"] . '">
									</form>
									<a href="javascript:goToDestination(&quot;postLink' . $i . '&quot;)">' . $row["title"] . '</a>
								</div>
								<div class="stars"><img src="' . $path . '" class = "starsImg" id = "' . $row["post_id"] . '">
								</div>
							</div>
							<div class="byRow">
								<div class="byLine">

									<form method="get" id="authorProfileLink' . $i . '" action="profile.php">
									<input type="hidden" name="username" value="' . $row["author"] . '">
									</form>
									Posted By: <a href="javascript:goToDestination(&quot;authorProfileLink' . $i . '&quot;)">' . $row["author"] . '</a> on ' . $row["date"] . ' | ' . $row["num_comments"] . ' comments | Topic: ' . $topic . '
								</div>
								<div class="ratingNum">
									' . $row["num_ratings"] . ' ratings
								</div>
							</div>
						</li>';
						$i++;
					}
				} else {
					echo "0 results";
				}
				?>

			</ul>

		</div>
		<!--
		<div class="pageSelect">
			Page: <a href="#">&lt;Prev</a>1<a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">Next&gt;</a>
		</div>
			-->
	</article>
</body>

</html>
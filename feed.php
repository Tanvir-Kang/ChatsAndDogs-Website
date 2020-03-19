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

	<article class="main">
		<div class="topbar">
			<select id="sort">
				<option value="topRated">Top-Rated</option>
				<option value="newest">Newest</option>
				<option value="oldest">Oldest</option>
				<option value="mostRatings">Most-Ratings</option>
				<option value="hot">Hot</option>
			</select>
			<a href="createApost.html">
				<div class="createPost">Create Post</div>
			</a>
			<div class="search"><img src="images/search.png"><input type="text" placeholder="Search" id="search" onkeyup="search( &quot;feed&quot;)" /></div>
			<h2 id="feedHeader">Feed</h2>

		</div>
		<div class="feedPort">
			<ul class="feedPosts">
			<?php
					$conn = OpenCon();
					$query = "SELECT title, num_ratings, avg_rating, date, author, num_comments FROM posts";
					$result = $conn->query($query);
					CloseCon($conn);
					if ($result->num_rows > 0) {
						// output data of each row
						$i = 0;
						while($row = $result->fetch_assoc()) {
							echo '<li class="post">
							<div class="titleRow">
								<div class="title">
									<a href="./post.html">'.$row["title"].'</a>
								</div>
								<div class="stars"><img src="images/star4.png">
								</div>
							</div>
							<div class="byRow">
								<div class="byLine">
								<form method="get" id="authorProfileLink'.$i.'" action="profile.php">
								<input type="hidden" name="username" value="'.$row["author"].'">
								</form>
									Posted By: <a href="javascript:goToProfile(&quot;authorProfileLink'.$i.'&quot;)">'.$row["author"].'</a> on '.$row["date"].' | 0 comments
								</div>
								<div class="ratingNum">
									'.$row["num_ratings"].' ratings
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
		<div class="pageSelect">
			Page: <a href="#">&lt;Prev</a>1<a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">Next&gt;</a>
		</div>
	</article>
</body>

</html>
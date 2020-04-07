<?php
session_start();
?>
<!--Load swals and jquery
	-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="js/sweetAlert/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script type="text/javascript">
	window.jQuery ||
		document.write('<script src="js/jquery-3.1.1.min.js"><\/script>');
</script>
<script>
	function topicSelect(topic) { // Function to determine which topics to display based on user feedback, using GET
		var posts = $(".post"); // All posts on page
		var pathname = $(location).attr('pathname').split("/");
		if (pathname[pathname.length-1] != "feed.php") // If user isn't at the feed
			window.location.href = "feed.php"; // Go to feed
		posts.each(function() {
			if (topic == "all")
				$(this).show(); // Show all elements
			else if ($(this).attr("id") == topic) // post topic equals user-defined topic
				$(this).show(); // show matching elements
			else
				$(this).hide(); // Hide non-matching elements
				
		});
	}
</script>
<header>
	<a href="feed.php"><img id="logo" src="images/logo_text.PNG" /></a>
	<?php if (isset($_SESSION['login'])) : ?>
		<div id="login">
			<a href="profile.php">
				<p>
					My Profile
				</p>
			</a>
			<a href="logout.php">
				<p style="border-top: solid black 1px;">
					Logout
				</p>
			</a>
		</div>
	<?php echo '<div align = "right" style= "padding-right: 4em;color: #61AEF0;margin-bottom: 0.5em">Logged in as: ' . $_SESSION["username"] . '</div>';
	else : ?>
		<div id="login">
			<a href="login.php">
				<p>
					Login
				</p>
			</a>
			<a href="signup.php">
				<p style="border-top: solid black 1px;">
					Sign Up
				</p>
			</a>
		</div>
	<?php endif; ?>
	<nav>
		<ul class="navbar">
			<a href="javascript:topicSelect('all')">
				<li>
					All Posts
				</li>
			</a>
			<a href="javascript:topicSelect('chats')">
				<li>
					Chats
				</li>
			</a>
			<a href="javascript:topicSelect('dogs')">
				<li>
					Advice
				</li>
			</a>
			<?php
			if (isset($_SESSION["admin"]))
				if($_SESSION["admin"] == true)
					echo '
						<a href="adminPanel.php">
							<li>
								Admin Panel
							</li>
						</a>'
			?>
		</ul>
	</nav>
</header>
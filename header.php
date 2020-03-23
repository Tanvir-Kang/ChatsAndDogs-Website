<?php
session_start();
?>
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
	<?php else : ?>
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
			<a href="feed.php">
				<li>
					Chats
				</li>
			</a>
			<a href="feed.php">
				<li>
					Advice
				</li>
			</a>
		</ul>

	</nav>
</header>
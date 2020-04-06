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
		</ul>
	</nav>
</header>
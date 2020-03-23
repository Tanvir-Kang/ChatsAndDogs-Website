<?php 
session_start();
session_destroy();
echo 'you have been logged out. Redirecting back to feed...';
echo "<script> window.location.assign('feed.php'); </script>";
?>
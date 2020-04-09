<?php 
//on log out unset all session variables and then let user know that they have been logged out
session_start();
session_unset();
session_destroy();
echo 'You have been logged out. Redirecting back to feed...';
echo "<script> window.location.assign('feed.php'); </script>";
?>
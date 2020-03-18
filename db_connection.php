<?php
function OpenCon()
{
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "test";
$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
echo "<h1>Succeeded<h1>";
return $conn;
}

function CloseCon($conn)
{
$conn -> close();
}
?>

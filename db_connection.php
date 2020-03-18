<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
    window.jQuery ||
        document.write('<script src="js/jquery-3.1.1.min.js"><\/script>');
</script>
<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "chats_and_dogs";
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);
    return $conn;
}

function CloseCon($conn)
{
    $conn->close();
}
?>
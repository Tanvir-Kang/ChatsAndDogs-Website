<?php
include 'db_connection.php';

$conn = OpenCon();

echo "Connected Successfully <br>";
$query = "SELECT name, age FROM person";
$result = $conn->query($query);
CloseCon($conn);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["name"]. " - Age: " . $row["age"]."<br>";
    }
} else {
    echo "0 results";
}
?>
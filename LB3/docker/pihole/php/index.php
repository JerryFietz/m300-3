<!DOCTYPE html>
<html>
<body>

<?php
$servername = "localhost";
$username = "dbuser";
$password = "1234";
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>


<p>The webserver too!! (duh)</p>

</body>
</html>
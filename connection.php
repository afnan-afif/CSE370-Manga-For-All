<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "MangaForAll";
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection Failed". $conn->connect_error);
}
else {
    echo "Connection Successful";
}
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tugas_tri";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo "<script>alert('Database Connected');</script>";

<?php
// Establish a database connection (replace with your database credentials)
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restonav";

$conn = new mysqli($servername, $username, $password, $dbname);
$user_id=$_SESSION['user_id'];
$restaurantname=$_SESSION['restaurant_name'];
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get latitude and longitude from the form submission
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Insert the data into the database
$sql = "INSERT INTO restaurant (latitude, longitude) VALUES (?, ?) where restaurant_name='$restaurantnam' and user_id='$user_id'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("dd", $latitude, $longitude);

if ($stmt->execute())
 {
    echo "Location data inserted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

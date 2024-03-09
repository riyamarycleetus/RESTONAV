<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database_name = "restonav";

$conn = mysqli_connect($servername, $username, $password, $database_name);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restaurant_id']) && isset($_POST['restaurantName']) && isset($_POST['contact'])) {
        $restaurantName = $_POST['restaurantName'];
        $resid = $_POST['restaurant_id'];
        $contact = $_POST['contact'];
        $user_id = $_SESSION['user_id'];

        // Fetch the current count of notifications for the restaurant
        $sql1 = "SELECT COUNT(*) as ncount FROM notification WHERE restaurant_id = '$resid'";
        $result = mysqli_query($conn, $sql1);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $ncount = $row['ncount'];

            // Construct the unique sid
            $sid = 'S' . $user_id . "-" . $resid . "-" . ($ncount + 1);

            // Get the current date and time
            $currentDateTime = date('Y-m-d H:i:s');

            // Insert the data into your "notification" table, including date and time
            $sql = "INSERT INTO notification (sid, restaurant_id, restaurant_name, contact, sent_datetime) 
                    VALUES ('$sid', '$resid', '$restaurantName', '$contact', '$currentDateTime')";
            
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Notification sent successfully!");</script>';
                
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo '<script>alert("ERROR FETCHING NOTIFICATION COUNT");</script>' . mysqli_error($conn);
        }
    } else {
        echo "Missing data for notification.";
    }
}


mysqli_close($conn);
?>

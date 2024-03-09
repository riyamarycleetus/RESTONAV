<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
 body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

header {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px;
}

.container {
    background-color: #fff;
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
}

.container h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

.container p {
    font-size: 18px;
    margin: 10px 0;
}

    </style>    
</head>

<body>
    <header>
        <h1>Restaurant Details</h1>
    </header>
    <div class="container">
        <?php
       
           
session_start();

$servername = 'localhost';
$username = 'root';
$password = '';
$database_name = 'restonav';

$conn = mysqli_connect($servername, $username, $password, $database_name);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql3 = "SELECT restaurant_name, restaurant_type FROM restaurant WHERE user_id = '$user_id'";

    $result2 = mysqli_query($conn, $sql3);

    if (!$result2) {
        die('Error: ' . mysqli_error($conn));
    }

    // Check if there are any matching rows
    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            $restaurantName = $row['restaurant_name'];
            $restaurantType = $row['restaurant_type'];

            // Display restaurant details in containers
            echo '<div class="container">';
            echo '<h1>' . $restaurantName . '</h1>';
            echo '<p>Restaurant Type: ' . $restaurantType . '</p>';
            echo '</div>';
        }
    } else {
        echo 'No matching restaurants found for user_id: ' . $user_id;
    }

    mysqli_close($conn);
} else {
    echo 'user_id parameter is missing.';
}

        ?>
    </div>
</body>
</html>

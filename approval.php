<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restonav";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['approve-restaurant'])) {
    $restaurantId = $_POST['restaurant-id'];

    // Insert the restaurant ID into the 'approved' table
    $insertQuery = "INSERT INTO approved (restaurant_id) VALUES (?)";
    $insertStmt = $conn->prepare($insertQuery);

    // Bind the parameter to the prepared statement
    $insertStmt->bind_param("i", $restaurantId); // "i" represents an integer

    if ($insertStmt->execute()) {
        $insertStmt->close(); // Close the insert statement

        // Update the status to "Approved" in the 'restaurant' table for the specific restaurant
        $updateQuery = "UPDATE restaurant SET status = 'Approved' WHERE restaurant_id = ?";
        $updateStmt = $conn->prepare($updateQuery);

        // Bind the parameter to the prepared statement
        $updateStmt->bind_param("i", $restaurantId); // "i" represents an integer

        if ($updateStmt->execute()) {
            // Successfully updated
        } else {
            // Handle update failure
        }
        $updateStmt->close(); // Close the update statement
    }
} elseif (isset($_POST['reject-restaurant'])) {
    $restaurantId = $_POST['restaurant-id'];

    // Update the status to "Rejected" and clear specific columns in the 'restaurant' table
    $updateQuery = "UPDATE restaurant SET status = 'Rejected', restaurant_name = '', city = '', contact = '', restaurant_type = '', latitude = '', logitude = '', rimage = '' WHERE restaurant_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    
    // Bind the parameter to the prepared statement
    $updateStmt->bind_param("i", $restaurantId); // "i" represents an integer

    if ($updateStmt->execute()) {
        // Successfully updated and cleared the data
        echo "Successfully updated and cleared the data for the restaurant.";
    } else {
        // Handle update failure
        echo "Update failed.";
    }
    
    $updateStmt->close();
}

$query = "SELECT * FROM restaurant";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="container">';
        echo '<h2>' . $row["restaurant_name"] . '</h2>';
        echo '<p><strong>Restaurant Type:</strong> ' . $row["restaurant_type"] . '</p>';
        echo '<p><strong>Contact:</strong> ' . $row["contact"] . '</p>';
        echo '<p><strong>City:</strong> ' . $row["city"] . '</p>';

        // Add a specific size to the image
        $imagePath = 'uploads/' . $row["rimage"];
        $imageWidth = '300px'; // Adjust to your desired width
        $imageHeight = '200px'; // Adjust to your desired height

        echo '<img src="' . $imagePath . '" alt="Restaurant Image" style="width: ' . $imageWidth . '; height: ' . $imageHeight . ';" />';

        echo '<form method="post">';
        
        echo '<button class="approve-button" type="submit" name="approve-restaurant">Approve</button>';
        echo '<button class="reject" type="submit" name="reject-restaurant">Reject</button>';
        echo '</form>';
        echo '</div>';
    }
} else {
    echo "No restaurants found in the database.";
}

$conn->close();

?>
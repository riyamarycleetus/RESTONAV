<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Restaurant Listings</title>
    <style>
                body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .restaurant-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .restaurant-container {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            max-width: 300px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .restaurant-container:hover {
            transform: scale(1.03);
        }

        .restaurant-image {
            max-width: 100%;
            height: auto;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            transition: border-color 0.3s ease-in-out;
        }

        input[type="text"]:focus {
            border-color: #007BFF;
        }

        .edit-button, .save-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease-in-out;
        }

        .edit-button:hover, .save-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
    session_start();

    // Your database connection code and session start should be here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database_name = "restonav";

    $conn = mysqli_connect($servername, $username, $password, $database_name);

    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql3 = "SELECT * FROM restaurant WHERE user_id = '$user_id'";
        $result2 = mysqli_query($conn, $sql3);

        if (!$result2) {
            die('Error: ' . mysqli_error($conn));
        }

        // Check if there are any matching rows
        if (mysqli_num_rows($result2) > 0) {
            $count = 0;
            echo '<div class="restaurant-row">';
            while ($row = mysqli_fetch_assoc($result2)) {
                $restaurantName = $row['restaurant_name'];
                $restaurantType = $row['restaurant_type'];
                $restaurantImage = $row['rimage']; // Assuming this is the column for the image file name
                
                echo '<div class="restaurant-container">';
                // Display the image with reduced size
                echo '<img class="restaurant-image" src="uploads/' . $restaurantImage . '" alt="' . $restaurantName . ' Image">';

                // Display restaurant details in input fields with labels
                echo '<label for="restaurant_name">Restaurant Name:</label>';
                echo '<input type="text" name="restaurant_name" id="restaurant_name" value="' . $restaurantName . '" readonly><br>';
                
                echo '<label for="restaurant_type">Restaurant Type:</label>';
                echo '<input type="text" name="restaurant_type" id="restaurant_type" value="' . $restaurantType . '" readonly><br>';
                
                echo '<label for="contact">Contact:</label>';
                echo '<input type="text" name="contact" id="contact" value="' . $row["contact"] . '" readonly><br>';
                
                echo '<label for="city">City:</label>';
                echo '<input type="text" name="city" id="city" value="' . $row["city"] . '" readonly><br>';

                // Edit and Save buttons for each restaurant
                echo '<button class="edit-button" data-id="' . $user_id . '">Edit</button>';
                echo '<button class="save-button" data-id="' . $user_id . '" style="display: none;">Save</button>';

                echo '</div>';
                
                $count++;
                if ($count % 3 == 0) {
                    // Close the current row and start a new one after every 3 restaurants
                    echo '</div><div class="restaurant-row">';
                }
            }
            echo '</div>'; // Close the final row
        } else {
            echo 'No matching restaurants found for user_id: ' . $user_id;
        }
    } else {
        echo 'user_id parameter is missing.';
    }

    // Close your database connection here
    mysqli_close($conn);
?>

<script>
    // JavaScript for enabling edit and save functionality
    const editButtons = document.querySelectorAll('.edit-button');
    const saveButtons = document.querySelectorAll('.save-button');
    const inputFields = document.querySelectorAll('input[type="text"]');

    editButtons.forEach((editButton) => {
        editButton.addEventListener('click', () => {
            const container = editButton.parentElement;
            const userId = editButton.getAttribute('data-id');

            // Enable input fields for editing
            inputFields.forEach((input) => {
                input.removeAttribute('readonly');
            });

            // Show the Save button and hide the Edit button
            container.querySelector('.save-button').style.display = 'inline-block';
            container.querySelector('.edit-button').style.display = 'none';
        });
    });

    saveButtons.forEach((saveButton) => {
        saveButton.addEventListener('click', () => {
            const container = saveButton.parentElement;
            const userId = saveButton.getAttribute('data-id');

            // Disable input fields for editing
            inputFields.forEach((input) => {
                input.setAttribute('readonly', true);
            });

            // Hide the Save button and show the Edit button
            container.querySelector('.save-button').style.display = 'none';
            container.querySelector('.edit-button').style.display = 'inline-block';

            // You can now send the updated data to the server using AJAX and PHP
            // For simplicity, this example does not include the AJAX part.
        });
    });
</script>

</body>
</html>

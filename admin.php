<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Restaurant Approval</title>
  
    <style>
    <style>
    body {
            font-family: Arial, sans-serif;
            text-align: center;
            
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .admin-panel {
            display: flex;
        }

        .restaurants {
            flex: 1;
            display: flex;
            flex-wrap: wrap; /* Enable wrapping of restaurant containers */
            

        }

        .notifications {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: left;
            max-width: 350px; /* Reduce the width of the notification area */
        }

        .notification-container {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            background-color: #f9f9f9;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #333;
        }

        .container {
            border: 1px solid #ddd;
            padding: 20px;
            display: inline-block;
            text-align: left;
            width: calc(33.33% - 70px); /* Set the width to 1/3 of the container's width minus margin */
            margin: 10px; /* Add margin to create spacing between restaurant containers */
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .container:hover {
            transform: scale(1.05);
        }

        button {
            background-color: beige;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        button.reject {
            background-color: #ff4444;
            color:black;
        }

        .container img {
            max-width: 100%;
            height: auto;
        }

        .buttons-container {
            width: 350px; 
            padding: 20px;
            background-color: beige;
            color: black;
            padding: 20px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;

                } 
        .navbar {
            background-color:transparent;
            color: #fff;
            padding: 10px;
            text-align: right;
            
            background-color: black;
}

.navbar a {
    color: white;
    text-decoration: none;
    margin: 0 20px;
}

    </style>
    </style>
</head>
<body style="background-color:#534d3c;">
   <div class="navbar">
        <a href="home.html" >HOME</a>
        <a href="logout.php">LOGOUT</a>
    </div>
    <br>
    <br>
    

    <div class="admin-panel">
  
        <div class="restaurants">
            
            <?php
            session_start();

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "restonav";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            if (isset($_POST['approve-restaurant'])) {
                // Get the restaurant ID from the form submission
            
                $resid = $_POST['restaurant-id'];
                
                $update_query = "UPDATE restaurantlogs SET status = 'approved' WHERE restaurant_id = '$resid'";
                $result3 = $conn->query($update_query);
                // Retrieve the details of the restaurant to be approved
                $query2 = "SELECT * FROM restaurant WHERE restaurant_id = '$resid' ";
                $result2 = $conn->query($query2);
            
                if ($result2->num_rows == 1) {
                    $row2 = $result2->fetch_assoc();
            
                    // Insert the restaurant details into the "approved" table
                    $insert_query = "INSERT INTO approved (user_id,restaurant_id,restaurant_name, restaurant_type, contact, city, rimage) 
                                    VALUES (
                                        '" . $row2['user_id'] . "',
                                        '" . $row2['restaurant_id'] . "',
                                        '" . $row2['restaurant_name'] . "',
                                        '" . $row2['restaurant_type'] . "',
                                        '" . $row2['contact'] . "',
                                        '" . $row2['city'] . "',
                                        '" . $row2['rimage'] . "'
                                    )";
            
                    if ($conn->query($insert_query) === TRUE) {
                        $sql = "DELETE FROM restaurant WHERE restaurant_id = '$resid'";

                        // Execute the DELETE statement
                        if (mysqli_query($conn, $sql)) {
                            
                        } else {
                            echo "Error deleting record: " . mysqli_error($conn);
                        }

                       
                    } else {
                        echo "Error: " . $insert_query . "<br>" . $conn->error;
                    }
                }
            
            }
            if (isset($_POST['reject-restaurant'])) {
                $resid = $_POST['restaurant-id'];
            
                // Update the status to 'rejected' in the 'restaurant' table
                $update_query = "UPDATE restaurantlogs SET status = 'rejected' WHERE restaurant_id = '$resid'";
            
                if ($conn->query($update_query) === TRUE) {
                    
                    $sql = "DELETE FROM restaurant WHERE restaurant_id = '$resid'";

                        // Execute the DELETE statement
                        if (mysqli_query($conn, $sql)) {
                            
                        } 
                } else {
                    echo "Error updating restaurant status: " . $conn->error;
                }

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
                    
                    $imagePath = 'uploads/' . $row["rimage"];
                    $imageWidth = '300px';
                    $imageHeight = '200px';
                    echo '<img src="' . $imagePath . '" alt="Restaurant Image" style="width: ' . $imageWidth . '; height: ' . $imageHeight . ';" />';
                    echo '<form method="post">';
                    echo '<input type="hidden" name="restaurant-id" value="' . $row["restaurant_id"] . '">';

                    
                    $restaurant_id = $row["restaurant_id"];
                    $ownerQuery = "SELECT * FROM owner_details WHERE restaurant_id = '$restaurant_id'";
                     $ownerResult = $conn->query($ownerQuery);
                    if ($ownerResult->num_rows > 0) {
                        $ownerRow = $ownerResult->fetch_assoc();
                
                        // Display owner details
                        echo '<p><strong>Owner Name:</strong> ' . $ownerRow["owner_name"] . '</p>';
                        echo '<p><strong>Owner Contact:</strong> ' . $ownerRow["owner_contact"] . '</p>';
                        
                        $panCardFilename = $ownerRow["pan_card"];
                        $restaurantLicenseFilename = $ownerRow["restaurant_license"];
                
                        // Construct the file paths
                        $panCardFilePath = 'owner/' . $panCardFilename;
                        $restaurantLicenseFilePath = 'owner/' . $restaurantLicenseFilename;
                
                        // Display PAN Card and Restaurant License images
                        echo '<p><strong>PAN Card:</strong></p>';
                        echo '<img src="' . $panCardFilePath . '" alt="PAN Card" style="width: 300px; height: 200px;">';

                        echo '<p><strong>Restaurant License:</strong></p>';
                        echo '<img src="' . $restaurantLicenseFilePath . '" alt="Restaurant License" style="width: 300px; height: 200px;">';
                        echo '<button class="approve-button" type="submit" name="approve-restaurant">Approve</button>';
                        echo '<button class="reject" type="submit" name="reject-restaurant">Reject</button>';
                        echo '</form>';
                    }
                         else {
                        echo 'Owner details not found for this restaurant.';
                    }
                    echo '</div>';

                }

            } else {
                echo "   ";
                echo "      NO NEW RESTAURANTS!ALL DONE";
            }
            
            
            $conn->close();            
            ?>
        </div>
        <div class="notifications">
           
                <h2>Surplus Food Alerts</h2>

                <?php
               
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "restonav";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve notifications from the "notification" table
                $query = "SELECT * FROM notification";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="notification-container">';
                        echo '<p><strong>Restaurant Name:</strong> ' . $row["restaurant_name"] . '</p>';
                        echo '<p><strong>Contact:</strong> ' . $row["contact"] . '</p>';
                        echo '<p><strong>Sent Date and Time:</strong> ' . $row["sent_datetime"] . '</p>';
                        echo '<p><strong>Status:</strong> ' . $row["status"] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "No surplus food alerts found in the database.";
                }
                
                $conn->close();
                ?>
         
                 <div>
                 <a id="linkButton" href="restaurants.php" style="display: none;"></a>
                 <button class="buttons-container" onclick="document.getElementById('linkButton').click()">View restaurants</button><br><br>
                 <button class="buttons-container" onclick="window.location.href='https://mail.google.com/mail/u/0/#inbox'">Check Emails</button>
                 </div>
        </div>  
            
        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Your JavaScript code goes here.
    </script>
    
</body>
</html>

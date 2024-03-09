<?php
        session_start();
        ?>
<!DOCTYPE html>
<html>
<head>
    <title>Web Page with Buttons</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <style>
        /* Apply background image to the body */
        body {
            background-image: url('1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            margin: 0;
            padding: 0;
            font-family:  'Poppins', sans-serif;
            color:black;
        }

        /* Style the buttons */
        .button-container {
            text-align: center;
            padding: 60px;
        }

        /* Style the buttons */
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: beige;
            color:black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .button:hover {
            transform: scale(1.05); /* Enlarge the button by 10% on hover */
        }

        /* Style the container */
        .container {
            width: 70%;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            
            display: none; /* Hide the container by default */
            color: rgb(52, 49, 49);
        }

        .container-content {
            color:black;
            font-size: 18px;
        }

        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
        .header {
            background-color: transparent;
            color: #fff;
            padding: 20px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family:  'Poppins', sans-serif;
            font-weight: bold;
            transition: all 0.2s ease-in-out;
        }
        .header:hover{
            transform: scale(1.1);
             color: #b3121faf;
        }
        .containerar {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin: 20px;
            padding: 20px;
        }

        .containerarar h2 {
            margin-top: 0;
        }

        .form-groupar {
            margin-bottom: 15px;
        }

        .labelar {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            width: 60%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 2px;
        }

        .buttonar {
            background-color:beige;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            
            
        }
        .h1{
            color:beige;

        }
        .restaurant-name {
        font-size: 24px; /* Adjust the font size as needed */
        text-transform: uppercase; /* Convert text to uppercase */
        margin-top: 10px; /* Add some spacing */
        color:;
    }
    .details{
        text-align: left;
        color: white;
    }
    /* Add this CSS to your existing styles */
.containerar {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    margin: 20px;
    padding: 20px;
    text-align:; /* Center the content horizontally */
}

.containerar h2 {
    margin-top: 0;
    color: #333; /* Set the text color */
}

.containerar p {
    color: #666; /* Set the text color */
}

.containerar img {
    max-width: 300px; /* Limit the image width */
    max-height: 200px; /* Limit the image height */
    margin-top: 10px; /* Add some space below the image */
}

/* Add this CSS to your existing styles */
.buttons-container {
    margin-top: 10px;
    text-align: center;
    
}

.edit-button, .notify-button {
    background-color: beige;
    color: black;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px; /* Add margin between buttons */
}

/* Optionally, you can add hover effects to the buttons */
.edit-button:hover, .notify-button:hover {
    transform: scale(1.05); /* Enlarge the button on hover */
}

    
    </style>


</head>

        <?php
        $servername = 'localhost';
        $username = 'root';
        $password = "";
        $database_name = 'restonav';
        
        $conn = mysqli_connect($servername, $username, $password, $database_name);
        $user_id=$_SESSION['user_id'];
        if (!$conn) {
            die('Connection failed: ' . mysqli_connect_error());
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['submit'])) {
                $restaurantname = $_POST['restaurantname'];
                $restauranttype = $_POST['restauranttype'];
                $phonenumber = $_POST['phonenumber'];
                $city = $_POST['city'];
                $latitude = $_POST['latitude'];
                $longitude = $_POST['longitude'];               
        
                // Handle image upload
                $image_name = $_FILES['restaurantImages']['name'];
                $image_temp_name = $_FILES['restaurantImages']['tmp_name'];
                $image_directory = "uploads/"; // Specify your upload directory path
                $image_path = $image_directory . $image_name;
        
                if (move_uploaded_file($image_temp_name, $image_path)) {
                    // Image upload successful, insert data into the database
                    $sql = "INSERT INTO restaurant (user_id,restaurant_name, restaurant_type, contact, city, latitude, longitude, rimage)
                            VALUES ('$user_id','$restaurantname', '$restauranttype', '$phonenumber', '$city', '$latitude', '$longitude', '$image_name')";
                    
                    if (mysqli_query($conn, $sql)) {
                        // Data inserted successfully
                        echo "Restaurant added successfully.";
                    } 
                    else {
                        
                        echo "Error: " . mysqli_error($conn);
                    }
                }
                 else {
                    // Image upload failed
                    echo "Image upload failed.";
                }
            }
        }
               
           
        
        ?>
<body>
    <header>
        <button class="header">HOME</button>
        <button class="header">CONTACT US</button>
        <button id="form-open" class="header">ABOUT US</button>
    </header>
    <!-- Button container -->
    <div class="button-container">
        <!-- Button 1 -->
        <button class="button" id="addRestaurantButton">ADD YOUR RESTAURANT</button>

        <!-- Button 2 -->
        
            <button class="button" id="viewRestaurantsButton" >VIEW EXISTING RESTAURANTS</button>
    </div>

    <!-- Container below the buttons -->
    <div class="container" id="containerAddRestaurant">
        <h1 style="color:white;">Add Your Restaurant</h1>
        <p style="color:white;">List your restaurant with us to reach more people! Be ready with your pan card, restaurant license,restaurant images.We will verify and list your restaurant in our page soon.</p>
        <div class="container-content">
        <form method="POST" enctype="multipart/form-data">
            <div class="containerar">
                <h2>Restaurant Details</h2>
                <div class="form-groupar">
                    <labelar for="restaurantName">Restaurant Name:</labelar>
                    <input type="text" id="restaurantName" name="restaurantname" required>
                </div>
                <div class="form-groupar">
                    <labelar for="restaurantType">Restaurant Type:</labelar>
                    <select id="restaurantType" name="restauranttype" required>
                        <option value="pub">Pub</option>
                        <option value="cafe">Cafe</option>
                        <option value="streetfood">Street Food</option>
                        <option value="restaurant">Restaurant</option>
                    </select>
                </div>
                <div class="form-groupar">
                    <labelar for="phoneNumber">Phone Number:</labelar>
                    <input type="number" id="phoneNumber" name="phonenumber" required>

                </div>
                <div class="form-groupar">
                    <labelar for="city">city:</labelar>
                    <input type="text" id="city" name="city" step="any" required>
                    <br><br>
                    <labelar for="city">Location</labelar>
                    <div>
                    <p name="latitude">Latitude: <span id="latitude"></span></p>
                    <p name="logitude">Longitude: <span id="longitude"></span></p>
                    </div>
                    
                </div>
            </div>
            <!--
            <div class="containerar">
                <h2>Owner Details</h2>
                <div class="form-groupar">
                    <labelar for="ownerName">Owner Name:</labelar>
                    <input type="text" id="ownerName" name="ownerName" required>
                </div>
                <div class="form-groupar">
                    <labelar for="ownerContactNumber">Contact Number:</labelar>
                    <input type="number" id="ownerContactNumber" name="ownerContactNumber" required>
                </div>
                <div class="form-groupar">
                    <labelar for="panCard">Pan Card:</labelar>
                    <input type="file" id="panCard" name="panCard" required>

                </div>
                <div class="form-groupar">
                    <labelar for="restaurantLicense">Restaurant License:</labelar>
                    <input type="file" id="restaurantLicense" name="restaurantLicense" required>
                </div>
            </div>
            -->
            <div class="containerar">
                <h2>Restaurant Images</h2>
                <div class="form-groupar">
                    <labelar for="restaurantImages">Upload Images:</labelar>
                    <input type="file" id="restaurantImages" name="restaurantImages" accept="image/*"  required>
                </div>
            </div>
           
        
            <input class="buttonar" type="submit" name="submit" value="Submit">
        </form>
            
        </div>
    </div>

    <div class="container" id="containerViewRestaurants">
    <h1 style="color:white;">View Existing Restaurants</h1>
    <div class="container-content">
        <?php
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
                    while ($row = mysqli_fetch_assoc($result2)) {
                        $restaurantName = $row['restaurant_name'];
                        $restaurantType = $row['restaurant_type'];
                        $restaurantImage = $row['rimage']; // Assuming this is the column for the image file name
    
                        echo '<div class="containerar">';
                        // Display the image with reduced size
                        echo '<img src="uploads/' . $restaurantImage . '" alt="' . $restaurantName . ' Image" style="max-width: 300px; max-height: 200px;">';
                           // Display restaurant details in containers
                           
                           echo '<h2>' . $restaurantName . '</h2>';
                           echo '<p>Restaurant Type: ' . $restaurantType . '</p>';
                           echo '<p><strong>Contact:</strong> ' . $row["contact"] . '</p>';
                           echo '<p ><strong>City:</strong> ' . $row["city"] . '</p>';
                           echo '<div class="buttons-container">';
                           echo '<button class="edit-button">EDIT DETAILS</button>';
                           echo '<button class="notify-button">NOTIFY FOR SURPLUS FOOD</button>';
                           echo ' </div>';
                           echo '</div>';
                    }
                } else {
                    echo 'No matching restaurants found for user_id: ' . $user_id;
                }
            } else {
                echo 'user_id parameter is missing.';
            }
    
            // Close your database connection here
            mysqli_close($conn);
            ?>
        </div>
    </div>
    <script>
        // Get references to the buttons and containers
        
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            document.getElementById("latitude").textContent = latitude;
            document.getElementById("longitude").textContent = longitude;
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }

        // Call the function to get the current location
        getLocation();

                // Add the 'required' attribute to all input and select elements
                const formFields = document.querySelectorAll('input, select');
                formFields.forEach(field => {
                    field.setAttribute('required', 'true');
                });  
                </script>
   

</body>
</html>

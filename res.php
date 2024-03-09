<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>ADD RESTAURANT</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <style>
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
<body>
    <header>
        <a id="linkButtonh" href="home.html" style="display: none;"></a>
        <button class="header" onclick="document.getElementById('linkButtonh').click()">HOME</button>
        <button class="header">CONTACT US</button>
        <button id="form-open" class="header">ABOUT US</button>
        <a id="linkButton1" href="logout.php" style="display: none;"></a>
        <button class="header" onclick="document.getElementById('linkButton1').click()">LOGOUT</button>
    </header>
    <!-- Button container -->
    <div class="button-container">
        <!-- Button 1 -->
        <button class="button" id="addRestaurantButton">ADD YOUR RESTAURANT</button>

        <!-- Button 2 -->
        <button class="button" id="viewRestaurantsButton">VIEW EXISTING RESTAURANTS</button>
    </div>
    
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database_name = "restonav";
        
        $conn = mysqli_connect($servername, $username, $password, $database_name);
        $user_id=$_SESSION['user_id'];
        if (!$conn) {
            die('Connection failed: ' . mysqli_connect_error());
        }
        if (!isset($_SESSION['user_id'])) 
        {
            echo '<script>alert("Please login to add/view your existing restaurants!");</script>';
            echo '<script>window.location.href = "home.html";</script>';
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['submit'])) {
                $restaurantname = $_POST['restaurantname'];
                $restauranttype = $_POST['restauranttype'];
                $phonenumber = $_POST['phonenumber'];
                $city = $_POST['city'];
        
                // Handle image upload
                $image_name = $_FILES['restaurantImages']['name'];
                $image_temp_name = $_FILES['restaurantImages']['tmp_name'];
                $image_directory = "uploads/"; // Specify your upload directory path
                $image_path = $image_directory . $image_name;
                $menu_image_name = $_FILES['menuImages']['name'];
                $menu_image_temp_name = $_FILES['menuImages']['tmp_name'];
                $menu_image_directory = "Menu/"; // Specify the folder path for menu images
                $menu_image_path = $menu_image_directory . $menu_image_name;
                
                $ownerName = $_POST['ownerName'];
                $ownerContactNumber = $_POST['ownerContactNumber'];
                
                $panCardName = $_FILES['panCard']['name'];
                $panCardTempName = $_FILES['panCard']['tmp_name'];
                $restaurantLicenseName = $_FILES['restaurantLicense']['name'];
                $restaurantLicenseTempName = $_FILES['restaurantLicense']['tmp_name'];

                // Move uploaded files
                

                if (move_uploaded_file($image_temp_name, $image_path) && move_uploaded_file($menu_image_temp_name, $menu_image_path)) {
                    // Image upload successful, insert data into the database
        
                    // Calculate the number of existing restaurants for the user
                    $user_id = $_SESSION['user_id'];
                    $sql = "SELECT COUNT(*) as restaurant_count FROM restaurant WHERE user_id = '$user_id'";
                    $result = mysqli_query($conn, $sql);
        
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $restaurant_count = $row['restaurant_count'];
        
                        // Calculate the new restaurant ID
                        $restaurant_id = 'R' . $user_id . "" . ($restaurant_count + 1);
        
                        // Now you can use $restaurant_id to insert into the database
                        $sql = "INSERT INTO restaurant (user_id, restaurant_id, restaurant_name, restaurant_type, contact, city, rimage,menu)
                        VALUES ('$user_id', '$restaurant_id', '$restaurantname', '$restauranttype', '$phonenumber', '$city', '$image_name','$menu_image_name')";
        
                        // Insert the data into the database
                        if (mysqli_query($conn, $sql)) {
                            // Data inserted successfully
                            echo "Restaurant added successfully with ID: $restaurant_id.";
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                        $sql2 = "INSERT INTO restaurantlogs (user_id,restaurant_id, restaurant_name, restaurant_type, contact, city, rimage,menu)
                                     VALUES ('$user_id','$restaurant_id', '$restaurantname', '$restauranttype', '$phonenumber', '$city', '$image_name','$menu_image_name')";
        
                        // Insert the data into the restaurantlogs table
                        if (mysqli_query($conn, $sql2)) {
                            // Data inserted successfully in the restaurantlogs table
                            echo "Restaurant added successfully with ID: $restaurant_id.";
                        } else {
                            echo "Error inserting data into restaurantlogs: " . mysqli_error($conn);
                        }

                        $panCardPath = "owner/" . $panCardName;
                        $restaurantLicensePath = "owner/" . $restaurantLicenseName;

                        if (move_uploaded_file($panCardTempName, $panCardPath) && move_uploaded_file($restaurantLicenseTempName, $restaurantLicensePath)) {
                            // Insert owner details into the database
                            $sql_owner = "INSERT INTO owner_details (user_id, restaurant_id, owner_name, owner_contact, pan_card, restaurant_license)
                            VALUES ('$user_id', '$restaurant_id', '$ownerName', '$ownerContactNumber', '$panCardName', '$restaurantLicenseName')";

                            if (mysqli_query($conn, $sql_owner)) {
                                // Data inserted successfully
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                        } else {
                            // Image upload failed for owner details
                            echo "Image upload failed for owner details.";
                        }

                    } else {
                        echo "Error calculating the restaurant count.";
                    }
                } else {
                    // Image upload failed
                    echo "Image upload failed.";
                }
            }
        }    
           
        
        ?>
    <!-- Container for Add Restaurant -->
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
                    <a id="linkButton2" href="location.html" style="display: none;"></a>
                    <button class="button"  onclick="document.getElementById('linkButton2').click()">GET LOCATION</button>
                    
                </div>
            </div>
            
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
        
            <div class="containerar">
                <h2>Restaurant Images</h2>
                <div class="form-groupar">
                    <labelar for="restaurantImages">Restaurant Images:</labelar>
                    <input type="file" id="restaurantImages" name="restaurantImages" required>
                </div>
                <div class="form-groupar">
                <labelar for="menuImages">Menu Images:</labelar>
                <input type="file" id="menuImages" name="menuImages" required>
              </div>
            </div>                 
            <input class="buttonar" type="submit" name="submit" value="Submit">
        </form>
            
        </div>
    </div>

    <!-- Container for View Existing Restaurants -->
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
                $sql3 = "SELECT * FROM approved WHERE user_id = '$user_id'";
                $result2 = mysqli_query($conn, $sql3);
    
                if (!$result2) {
                    die('Error: ' . mysqli_error($conn));
                }
    
                // Check if there are any matching rows
                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        $restaurantName = $row['restaurant_name'];
                        $restaurant_id = $row['restaurant_id'];
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
                           echo '<form method="POST" action="save-notification.php">';
                            echo '<input type="hidden" name="restaurant_id" value="' . $restaurant_id . '">';
                            echo '<input type="hidden" name="restaurantName" value="' . $restaurantName . '">';
                            echo '<input type="hidden" name="contact" value="' . $row["contact"] . '">';
                            echo '<button class="notify-button" type="submit">NOTIFY FOR SURPLUS FOOD</button>';
                            echo '</form>';
                           echo ' </div>';
                           echo '</div>';
                           echo '<a id="linkButton4" href="contact.html" style="display: none;"></a>';

                           echo '<button class="edit-button" type="submit" name="edit" onclick="document.getElementById("linkButton4").click()" >EDIT DETAILS</button>';
    
                    }
                } else {
                    echo 'No matching restaurants found for user_id: ' . $user_id;
                }
                
                
                
            } else {
                echo 'user_id parameter is missing.';
            }
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $sql3 = "SELECT * FROM restaurantlogs WHERE user_id = '$user_id'";
                $result2 = mysqli_query($conn, $sql3);
    
                if (!$result2) {
                    die('Error: ' . mysqli_error($conn));
                }
    
                // Check if there are any matching rows
                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        $restaurantName = $row['restaurant_name'];
                        $status = $row['status']; // Assuming this is the column for the restaurant status
    
                        echo '<div class="containerar">';
                        echo '<h2 class="restaurant-name">' . $restaurantName . '</h2>';
                        echo '<p class="details"><strong>Status:</strong> ' . $status . '</p>';
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
    </div>

    <script>
        const addRestaurantButton = document.getElementById("addRestaurantButton");
        const viewRestaurantsButton = document.getElementById("viewRestaurantsButton");
        const containerAddRestaurant = document.getElementById("containerAddRestaurant");
        const containerViewRestaurants = document.getElementById("containerViewRestaurants");

        // Function to display the "Add Restaurant" container and hide the "View Restaurants" container
        function showAddRestaurantContainer() {
            containerAddRestaurant.style.display = "block";
            containerViewRestaurants.style.display = "none";
        }

        // Function to display the "View Restaurants" container and hide the "Add Restaurant" container
        function showViewRestaurantsContainer() {
            containerAddRestaurant.style.display = "none";
            containerViewRestaurants.style.display = "block";
        }

        // Add event listeners to the buttons to call the respective functions
        addRestaurantButton.addEventListener("click", showAddRestaurantContainer);
        viewRestaurantsButton.addEventListener("click", showViewRestaurantsContainer);

        
       
        // Add the 'required' attribute to all input and select elements
        const formFields = document.querySelectorAll('input, select');
        formFields.forEach(field => {
        field.setAttribute('required', 'true');
        });  
         
        

        
    </script>
</body>
</html>

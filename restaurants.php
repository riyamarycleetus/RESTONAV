<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find restaurants</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <!-- For favicon png -->
		

       <!--bootstrap.min.css-->
       <link rel="stylesheet" href="css/bootstrap.min.css">
       
       <!--style.css-->
       <link rel="stylesheet" href="css/style.css">
       
       
    <style>
         body {
            font-family: 'Poppins', sans-serif;
            background-color:darkgray;
            margin: 0;
            padding: 0px;
        }
        header {
            background-color:transparent;
            color: #fff;
            padding: 10px;
            text-align: right;
        }
        .containernew {
            
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 10px;
            padding: 20px;
            width: calc(33.33% - 20px); /* Three containers in a row */
            float: left;
            height: 400px; /* Set a fixed height for the containers */
            background-color: rgba(255, 255, 255, 0.8);
        }

        .containernew img {
            height: 60%; /* Make sure images don't exceed the container height */
            
            width: 90%; /* Maintain aspect ratio */
        }
        h2 {
            color: #333;
        }
        .restaurant-image {
            max-width: 100%;
            height: auto;
        }
        .welcome-hero-form {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
    }

    .welcome-hero-form .search-container {
        display: flex;
        align-items: center;
        max-width: 70%;
    }

    .searchinp {
        flex-grow: 1;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        max-width: 60%;
        height: 80px;
    }

    .sbtn {
        background-color: #333;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        height: 80px;
        width: 100px;
    }

    .welcome-hero-txt {
        margin-bottom: 20px; /* Add space between the text and the search input */
    }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius:;
        }
        button[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        /* Clear floats after every third container to start a new row */
        .container:nth-child(3n+1) {
            clear: both;
        }

        .restaurant-icons {
            margin-top: 10px;
        }

        .restaurant-icons a {
            text-decoration: none;
            color:black;
            margin: 5px;
            font-size: 15px;
        }
        .restaurant-name {
        font-size: 24px; /* Adjust the font size as needed */
        text-transform: uppercase; /* Convert text to uppercase */
        margin-top: 10px; /* Add some spacing */
    }
    .details{
        text-align: left;
    }
        
    </style>
</head>
<body>


    <section id="home" class="welcome-hero">
    <header>
        <a id="linkButtonh" href="home.html" style="display: none;"></a>
        <button class="header" onclick="document.getElementById('linkButtonh').click()">HOME</button>

    </header>
			<div class="container">
				<div class="welcome-hero-txt">
					<h2>best place to find and explore <br> all you need </h2>
					<p>Find Best Restaurants, Cafe, Pubs and Street foods in just One click 
					</p>
				</div>

				
             <form method="POST">   
                <DIV>
                <input class="searchinp" type="text" name="search2" placeholder="Enter location or restaurant type Ex: Bangalore, Kochi or cafe,street food etc" />                
		
                <button class= "sbtn" type="submit">Search</button>
                </div>
           </form>
					
				

		</section>

        <?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restonav";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $search2 = $_POST["search2"];
        // Perform the database query
        $query = "SELECT * FROM approved WHERE city LIKE '%$search2%' OR restaurant_type LIKE '%$search2%' ";
        $result = $conn->query($query);

    // Display restaurant data and images in containers
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="containernew">';
            $file_url = 'uploads/'. $row["rimage"];
            // Check if the image file exists before displaying it
            if (file_exists($file_url)) {
                echo '<img src="'. $file_url . '" alt="Restaurant Image" />';
            }           
            else{
                echo "sorry";
            }
        echo '<br>';
        echo '<h1 class="restaurant-name">' . strtoupper($row["restaurant_name"]) . '</h1>'; 
        echo '<p class="details"><strong>Restaurant Type:</strong> ' . $row["restaurant_type"] . '</p>';
        echo '<p class="details"><strong>Contact:</strong> ' . $row["contact"] . '</p>';
        echo '<p class="details"><strong>City:</strong> ' . $row["city"] . '</p>';
        //echo '<p><strong>Opens:</strong> ' . $row["open_time"] . '</p>';
        //echo '<p><strong>Closes:</strong> ' . $row["close_time"] . '</p>';
        echo '<div class="restaurant-icons">';
        echo '<a href="#">';
        echo '<i class="fas fa-map-marker-alt"></i>  Location';
        echo '</a>';
        echo '<a href="#">';
        echo '<i class="fas fa-utensils"></i>  Menu';
        echo '</a>';
        echo '</div>';
        echo '</div>';
        
        
        echo '</div>';
        }
    } 
    else {
        echo "NO RESTAURANTS MATCH!";

    }
}
else{
    $queryn = "SELECT * FROM approved";
    $resultn = $conn->query($queryn);

// Display restaurant data and images in containers
if ($resultn->num_rows > 0) {
    while ($row = $resultn->fetch_assoc()) {
        echo '<div class="containernew">';
        $file_url = 'uploads/'. $row["rimage"];
        // Check if the image file exists before displaying it
        if (file_exists($file_url)) {
            echo '<img src="'. $file_url . '" alt="Restaurant Image" />';
        }           
        else{
            echo "sorry";
        }
    echo '<br>';
    echo '<h1 class="restaurant-name">' . strtoupper($row["restaurant_name"]) . '</h1>'; 
    echo '<p class="details"><strong>Restaurant Type:</strong> ' . $row["restaurant_type"] . '</p>';
    echo '<p class="details"><strong>Contact:</strong> ' . $row["contact"] . '</p>';
    echo '<p class="details"><strong>City:</strong> ' . $row["city"] . '</p>';
    //echo '<p><strong>Opens:</strong> ' . $row["open_time"] . '</p>';
    //echo '<p><strong>Closes:</strong> ' . $row["close_time"] . '</p>';
    
    // Add icons and links for location and menu
    echo '<div class="restaurant-icons">';
    echo '<a href="#">';
    echo '<i class="fas fa-map-marker-alt"></i>  Location';
    echo '</a>';
    echo '<a href="#">';
    echo '<i class="fas fa-utensils"></i>  Menu';
    echo '</a>';
    echo '</div>';
    echo '</div>';
}}}

    // Close the database connection
    $conn->close();
?>

</body>
</html>

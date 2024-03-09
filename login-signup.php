<?php
// Database connection
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "restonav";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle sign-up
if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO login_signup (emailid, password) VALUES ('$email', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        session_start(); // Start the session

        // Retrieve the user ID of the newly signed up user
        $user_id = mysqli_insert_id($conn);
        // Set the user ID in the session
        $_SESSION['user_id'] = $user_id;
        echo '<script>alert("Welcome,Signed up and ready to go!!");</script>';
        echo '<script>window.location.href = "home.html";</script>';
        
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Handle login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email === 'admin@gmail.com' && $password === 'admin') {
        // If the username and password are "admin," redirect to admin.php
        header("Location: admin.php");
        exit();}
    $sql = "SELECT * FROM login_signup WHERE emailid='$email'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } 
    else {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['user_id'] = $row['user_id'];
                
                echo '<script>alert("Welcome,Logged in!");</script>';
                echo '<script>window.location.href = "home.html";</script>';
                
                exit();
            } else {
                echo '<script>alert("Incorrect password");</script>';
                echo '<script>window.location.href = "home.html";</script>';
            }
        } else {
            echo '<script>alert("User not found.");</script>';
            echo '<script>window.location.href = "home.html";</script>';
        }
    }
}
mysqli_close($conn);
?>

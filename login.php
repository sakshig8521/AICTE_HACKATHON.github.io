<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginform";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the login form was submitted
if (isset($_POST['login'])) {
    // Retrieve the form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists in the database
    if ($result->num_rows === 1) {
        // User exists, verify the password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, perform desired actions (e.g., redirect to a dashboard page)
            echo "Login successful";
        } else {
            // Password is incorrect
            echo "Invalid password";
        }
    } else {
        // User does not exist
        echo "User not found";
    }

    // Close the database connection
    $stmt->close();
}

$conn->close();
?>

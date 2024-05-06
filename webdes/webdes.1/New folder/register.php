<?php
// Database configuration
$host = 'localhost'; // Hostname of the MySQL server
$username = 'root'; // MySQL username
$password = ''; // MySQL password
$database = 'project'; // Name of the database

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate the data (you can add more validation as needed)
    if (empty($username) || empty($password)) {
        $response = array("status" => "error", "message" => "Please fill all fields.");
    } else {
        // Insert user credentials into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            $response = array("status" => "success", "message" => "Registration successful!", "redirect_url" => "project.html");
        } else {
            $response = array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error);
        }
    }
    // Send JSON response back to the HTML page
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the form is not submitted, return an error response
    $response = array("status" => "error", "message" => "Form submission error.");
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close connection
$conn->close();
?>

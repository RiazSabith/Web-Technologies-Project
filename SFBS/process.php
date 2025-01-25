<?php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'sport');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); 
    $username = htmlspecialchars(trim($_POST['username']));
    $role = htmlspecialchars(trim($_POST['role']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if username already exists
    $username_query = "SELECT * FROM user_info WHERE username = '$username'";
    $username_result = $conn->query($username_query);

    if ($username_result->num_rows > 0) {
        echo "<script>alert('username has to be unique!'); window.location.href='signup.php';</script>";
    } else {
        // Insert into the database
        $query = "INSERT INTO user_info (first_name, last_name, dob, email, username, role, password) 
                  VALUES ('$first_name', '$last_name', '$dob', '$email', '$username', '$role', '$hashed_password')";

        if ($conn->query($query) === TRUE) {
            echo "Signup successful! <a href='login.php'>Login here</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

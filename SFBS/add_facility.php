<?php
require_once "db_connect.php";
    //session_start();
    $msg = "";
    // Sanitize input data
    $ground_name = $conn->real_escape_string($_POST['ground_name']);
    $ground_location = $conn->real_escape_string($_POST['ground_location']);
    $facility_type = $conn->real_escape_string($_POST['facility_type']);
    $available_duration = $conn->real_escape_string($_POST['available_duration']);
    $fees = $conn->real_escape_string($_POST['fees']);

    // Handle file upload
    $target_dir = "uploads/"; // Directory to store uploaded images
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
    }


if (!isset($_FILES['ground_picture']) || $_FILES['ground_picture']['error'] !== UPLOAD_ERR_OK) {
    die("Error: No file uploaded or there was an issue with the upload.");
}

    $target_file = $target_dir . basename($_FILES['ground_picture']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file type
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    // Move uploaded file to the target directory
    if (!move_uploaded_file($_FILES['ground_picture']['tmp_name'], $target_file)) {
        die("Error: There was an error uploading your file.");
    }

    // Insert data into the database
    $sql = "INSERT INTO facilities (ground_name, ground_location, facility_type, available_duration,fees,ground_picture)
            VALUES ('$ground_name', '$ground_location', '$facility_type', '$available_duration','$fees','$target_file')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New facility added successfully.'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <script>
    echo $msg; 
    </script>

</body>

</html>
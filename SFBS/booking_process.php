<?php

// Establish a database connection
require_once 'db_connect.php';

// Process the booking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_ground'])) {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']); // Sanitize input
    $id = mysqli_real_escape_string($conn, $_POST['id']); // Ground ID
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']); // Sanitize input

    // Check if the ground ID exists in the cookies
    if (isset($_COOKIE['id']) && $_COOKIE['id'] == $id) {
        // Ground ID already in cookies - it's not available
        echo "<p style='color:red;'>This ground is already booked by you or another user. Please choose a different ground.</p>";
    } else {

        // Save booking details in the database
        $query = "INSERT INTO bookings (user_name, id, booking_date) 
                  VALUES ('$user_name', '$id', '$booking_date')";

        if (mysqli_query($conn, $query)) {
            // Set cookies for ground_id and user_name ()
            setcookie("id", $id, time() + (30), "/"); 
            setcookie("username", $user_name, time() + (30), "/"); 

            echo "<p style='color:green;'>Ground booked successfully! A cookie has been created for this ground ID.</p>";
        } else {
            echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
}

// Close the database connection
mysqli_close($conn);

?>

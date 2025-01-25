<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sport";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process payment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay_now'])) {
    $id = $_POST['id'];
    $payment_method = $_POST['payment_method'];
    $amount = $_POST['amount'];

    // Fetch ground fee from `infacilities` table
    $stmt = $conn->prepare("SELECT fees FROM facilities WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fees = $row['fees'];

        if ($amount == $fees) {
            // Update booking status to 'confirmed' in `bookings` table
            $update_stmt = $conn->prepare("UPDATE bookings SET status = 'confirmed' WHERE id = ?");
            $update_stmt->bind_param("i", $id);

            if ($update_stmt->execute()) {
                echo "<script>alert('Payment successful! Your booking has been confirmed.'); window.location.href='user_dashboard.html';</script>";
            } else {
                echo "<p style='color:red; text-align:center;'>Error updating booking: " . $update_stmt->error . "</p>";
            }

            $update_stmt->close();
        } else {
            echo "<script>alert('The amount entered does not match the required ground fee '); window.location.href='payment.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid Ground ID. Please check and try again'); window.location.href='payment.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<?php
// Database connection
require_once 'db_connect.php'; 


// Fetch booking history
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ground</title>
    <style>
        /* Layout */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            display: flex;
            gap: 50px;
            margin-top: 20px;
        }

        .available-grounds {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        h3 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #34495e;
            color: white;
        }

        button:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>
    <h1>Booking History</h1>
    <div class="container">
        <div class="available-grounds">
            <h3>BOOKING HISTORY</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Ground Id</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Display booking data if available
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['booking_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No bookings found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

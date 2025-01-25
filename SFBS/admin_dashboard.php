<?php

// Database connection
require_once 'db_connect.php';

// Fetch facilities from the database
$sql = "SELECT * FROM facilities";
$result = $conn->query($sql);

// Update or delete functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        
        if (empty($id)) {
            echo "<script>alert('Please provide a valid Facility ID for updating.');</script>";
            exit;
        }

        // Fetch existing data for the facility
        $existing_data_sql = "SELECT * FROM facilities WHERE id = $id";
        $existing_data_result = $conn->query($existing_data_sql);

        if ($existing_data_result->num_rows > 0) {
            $existing_data = $existing_data_result->fetch_assoc();

            // Assign updated values or keep existing values
            $ground_name = !empty($_POST['ground_name']) ? $_POST['ground_name'] : $existing_data['ground_name'];
            $ground_location = !empty($_POST['ground_location']) ? $_POST['ground_location'] : $existing_data['ground_location'];
            $facility_type = !empty($_POST['facility_type']) ? $_POST['facility_type'] : $existing_data['facility_type'];
            $available_duration = !empty($_POST['available_duration']) ? $_POST['available_duration'] : $existing_data['available_duration'];
            $fees = !empty($_POST['fees']) ? $_POST['fees'] : $existing_data['fees'];

            // Check if a new image is uploaded
            $new_image = $_FILES['ground_picture']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($new_image);

            if (!empty($new_image)) {
                if (move_uploaded_file($_FILES['ground_picture']['tmp_name'], $target_file)) {
                    $ground_picture = $target_file; // Update with new image path
                } else {
                    echo "<script>alert('Error uploading the image.');</script>";
                    $ground_picture = $existing_data['ground_picture']; // Keep the old image path
                }
            } else {
                $ground_picture = $existing_data['ground_picture']; // Keep the old image path
            }

            // Update query with dynamic fields
            $update_sql = "UPDATE facilities SET 
                            ground_name = '$ground_name', 
                            ground_location = '$ground_location', 
                            facility_type = '$facility_type', 
                            available_duration = '$available_duration', 
                            fees = '$fees', 
                            ground_picture = '$ground_picture'
                            WHERE id = $id";

            if ($conn->query($update_sql) === TRUE) {
                echo "<script>alert('Facility updated successfully!'); </script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "<script>alert('No facility found with the given ID.');</script>";
        }
    }

  }




$conn->close();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Facility Booking - Admin Dashboard</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Dashboard Layout */
        body {
            display: flex;
            height: 100vh;
            background-color: #f4f4f9;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #ecf0f1;
        }

        .sidebar a {
            text-decoration: none;
            color: #ecf0f1;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .sidebar .logout {
            margin-top: auto;
            background-color: #e74c3c;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container h3 {
            margin-bottom: 20px;
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

        table tr:hover {
            background-color: #f2f2f2;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input, select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        
        <a href="user_information.php"> Manage User</a>
        <a href="add_facilities.html">➕ Add Facility</a>
        <a href="booking_history.php">BOOKING HISTORY</a>
        <a href="logout.php" class="logout">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Container: Display Facilities -->
        <div class="container" id="manage-facilities">
            <h3>Ground Availability</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ground Name</th>
                        <th>Location</th>
                        <th>Facility Type</th>
                        <th>Available Duration</th>
                        <th>Fees</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $counter = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $counter++; ?></td>
                                <td><?= htmlspecialchars($row['ground_name']); ?></td>
                                <td><?= htmlspecialchars($row['ground_location']); ?></td>
                                <td><?= htmlspecialchars($row['facility_type']); ?></td>
                                <td><?= htmlspecialchars($row['available_duration']); ?></td>
                                <td><?= htmlspecialchars($row['fees']); ?></td>
                                <td><img src="<?= htmlspecialchars($row['ground_picture']); ?>" alt="Ground Image" style="width: 100px; height: 80px; object-fit: cover;"></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No facilities available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="container">
            <h3>Update/Facility</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="id">Facility ID:</label>
                <input type="number" id="id" name="id" required>

                <label for="ground_name">Ground Name:</label>
                <input type="text" id="ground_name" name="ground_name" >

                <label for="ground_location">Ground Location:</label>
                <input type="text" id="ground_location" name="ground_location" >

                <label for="facility_type">Facility Type:</label>
                <select id="facility_type" name="facility_type" >
                    <option value="Football Ground">Football Ground</option>
                    <option value="Cricket Ground">Cricket Ground</option>
                    <option value="Badminton Court">Badminton Court</option>
                    <option value="Basketball Court">Basketball Court</option>
                    <option value="Tennis Court">Tennis Court</option>
                </select>

                <label for="available_duration">Available Duration:</label>
                <input type="text" id="available_duration" name="available_duration" placeholder="e.g., 8:00 AM - 10:00 PM" >

                <label for="fees">FEES:</label>
                <input type="text" id="fees" name="fees" placeholder="data" >

                <label for="ground_picture">Ground Image:</label>
                <input type="file" id="ground_picture" name="ground_picture" accept="image/*">

                <button type="submit" name="update">Update Facility</button>
            
            </form>
        </div>
    </div>
</body>
</html>

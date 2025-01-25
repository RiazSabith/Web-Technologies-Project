<?php
// Database connection
require_once 'db_connect.php'; 


// Fetch available grounds
$sql = "SELECT * FROM facilities";
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

        .available-grounds, .booking-form {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: scroll;
            overflow-x: scroll;
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

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        img {
            max-width: 150px;
            max-height: 100px;
            object-fit: cover;
        }

        button:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>
    <h1>Book a Sports Ground</h1>
    <div class="container">
        <!-- Available Grounds -->
        <div class="available-grounds">
            <h3>Available Grounds</h3>
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
                                <td><?=htmlspecialchars($row['fees']); ?></td>
                                <td>
                            <img src="<?= htmlspecialchars($row['ground_picture']); ?>" alt="Ground Image">
                        </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No grounds available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Booking Form -->
        <div class="booking-form">
            <h3>Book a Ground</h3>
            <form  action="booking_process.php" method="post" onsubmit="return validateForm()">
                <label for="user_name">Your Name:</label>
                <input type="text" id="user_name" name="user_name" required>

                <label for="id">Select Ground ID:</label>
                <input type="number" id="id" name="id" required>

                <label for="booking_date">Booking Date:</label>
                <input type="date" id="booking_date" name="booking_date" required>

                <button type="submit" name="book_ground">Book Ground</button>
            </form>

            <script>
    function validateBookingForm(event) {
        let isValid = true;

        // Get form field values
        const userName = document.getElementById('user_name').value.trim();
        const groundId = document.getElementById('id').value.trim();
        const bookingDate = document.getElementById('booking_date').value;

        // Validate User Name
        if (!/^[a-zA-Z\s]+$/.test(userName)) {
            alert("Name should only contain letters and spaces.");
            document.getElementById('user_name').focus();
            isValid = false;
        }

        // Validate Ground ID
        if (!/^\d+$/.test(groundId) || parseInt(groundId) <= 0) {
            alert("Ground ID should be a valid positive number.");
            document.getElementById('id').focus();
            isValid = false;
        }

        // Validate Booking Date (must not be in the past)
        const today = new Date().toISOString().split('T')[0]; // Current date in YYYY-MM-DD format
        if (bookingDate < today) {
            alert("Booking date cannot be in the past.");
            document.getElementById('booking_date').focus();
            isValid = false;
        }

        

        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault();
            return false;
        }

        return true; // Form is valid
    }

    // Attach the validation function to the form's submit event
    document.querySelector('form').addEventListener('submit', validateBookingForm);
</script>

        </div>
    </div>
</body>
</html>

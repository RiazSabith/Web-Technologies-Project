
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
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

        .user-information {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            max-height: 500px;
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

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>User Information</h1>
    <div class="container">
        <div class="user-information">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    require_once 'db_connect.php';

                   // Fetch user Information from the database
                   $sql = "SELECT * FROM user_info";
                   $result = $conn->query($sql);


                    // Check if there are rows in the result
                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']); ?></td>
                                <td><?= htmlspecialchars($row['first_name']); ?></td>
                                <td><?= htmlspecialchars($row['last_name']); ?></td>
                                <td><?= htmlspecialchars($row['dob']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['role']); ?></td>
                                <td>******</td> <!-- Masking password -->
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="8">No users found.</td>
                        </tr>
                    <?php endif;

                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

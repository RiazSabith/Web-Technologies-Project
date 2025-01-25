<?php
session_start();
require_once 'db_connect.php'; 

$msg = "";

if (isset($_POST['submit'])) {
    // Sanitize user inputs
    $username = mysqli_real_escape_string($conn, strtolower(trim($_POST['username'])));
    $password = trim($_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM user_info WHERE username ='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
 
     if ($count == 1) {
    
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Store user session
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; // Store role in the session

            // Redirect based on role
            if ($row['role'] === 'Admin') {
                header('Location: admin_dashboard.php');
            } elseif ($row['role'] === 'User') {
                header('Location: user_dashboard.php');
            } else {
                $msg = '<div class="alert alert-danger" style="margin-top:30px;">
                        <strong>Error!</strong> Invalid role assigned to your account.
                    </div>';
            }
            exit; // Always exit after redirecting
        } else {
            // Incorrect password
            $msg = '<div class="alert alert-danger" style="margin-top:30px;">
                    <strong>Unsuccessful!</strong> Incorrect password.
                </div>';
        }
    } else {
        // User not found
        $msg = '<div class="alert alert-danger" style="margin-top:30px;">
                <strong>Unsuccessful!</strong> User not found.
            </div>';
    }

   
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f2f2;
    }

    .container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
    }

    input[type="text"],
    input[type="password"],
    button[type="submit"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button[type="submit"] {
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #45a049;
    }

    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid transparent;
      border-radius: 4px;
    }

    .alert-danger {
      color: #a94442;
      background-color: #f2dede;
      border-color: #ebccd1;
    }

    .close {
      float: right;
      font-size: 21px;
      font-weight: 700;
      line-height: 1;
      color: #000;
      text-shadow: 0 1px 0 #fff;
      opacity: .2;
    }

    .close:hover {
      color: #000;
      text-decoration: none;
      opacity: .5;
    }

  </style>
</head>

<body>

  <div class="container">
    <?php echo $msg; ?>
    <h1 style="text-align: center;"> Login</h1>
    <form id="loginForm" method="post">
      <input id="username" type="text" name="username" placeholder="Username" required><br>
      <input id="password" type="password" name="password" placeholder="Password" required><br>
      <button type="submit" name="submit">Log in</button>
    </form>
  </div>

  <script>
    document.getElementById("loginForm").addEventListener("submit", function (event) {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;
      if (username === "" || password === "") {
        event.preventDefault();
        alert("Please fill in all fields.");z
      }
    });
  </script>
</body>

</html>
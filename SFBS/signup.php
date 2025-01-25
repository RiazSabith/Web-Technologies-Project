<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="main">
        <div class="box1">
            <form action="process.php" method="post" onsubmit="return validateForm()">
                <label for="first_name"><h3 style="text-align: center;">First Name:</h3></label>
                <input type="text" id="first_name" name="first_name" style="width: 600px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Data"><br>

                <label for="last_name"><h3 style="text-align: center;">Last Name:</h3></label>
                <input type="text" id="last_name" name="last_name" style="width: 600px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Data"><br>

                <label for="dob"><h3 style="text-align: center;">Date Of Birth</h3></label>
                <input type="date" id="dob" name="dob" style="width: 600px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Data"><br>

                <label for="email"><h3 style="text-align: center;">Email:</h3></label>
                <input type="text" id="email" name="email" style="width: 600px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Data"><br>

                <label for="username"><h3 style="text-align: center;">UserName:</h3></label>
                <input type="text" id="username" name="username" style="width: 600px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Data"><br>

                <label for="role"><h3 style="text-align: center;">User Type:</h3></label>
                <select id="role" name="role" style="width: 620px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="select">select</option>
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select><br>

                <label for="password"><h3 style="text-align: center;">Password</h3></label>
                <input type="password" id="password" name="password" style="width: 600px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Data"><br>

                <label for="confirm_password"><h3 style="text-align: center;">Confirm Password</h3></label>
                <input type="password" id="confirm_password" name="confirm_password" style="width: 600px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Data"><br>

                <input type="submit" style="width: 150px; padding: 8px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;" value="Submit">
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            var first_name = document.getElementById("first_name").value.trim();
            var last_name = document.getElementById("last_name").value.trim();
            var email = document.getElementById("email").value.trim();
            var username = document.getElementById("username").value.trim();
            var password = document.getElementById("password").value.trim();
            var confirm_password = document.getElementById("confirm_password").value.trim();
            var role = document.getElementById("role").value;

            if (!/^[a-zA-Z]*$/.test(first_name)) {
                alert("First name should not be empty or contain digits!");
                document.getElementById("first_name").focus();
                return false;
            }

            if (!/^[a-zA-Z]+$/.test(last_name)) {
                alert("Last name should not be empty or contain digits!");
                document.getElementById("last_name").focus();
                return false;
            }

            if (email === "") {
                alert("Email cannot be empty!");
                document.getElementById("email").focus();
                return false;
            }

           var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (!emailRegex.test(email)) {
                alert("Invalid email address!");
                document.getElementById("email").focus();
                return false;
            }

            if (username === "") {
                alert("Username cannot be empty!");
                document.getElementById("username").focus();
                return false;
            }

            if (role === "select") {
                alert("Please select an account type!");
                document.getElementById("role").focus();
                return false;
            }

           var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{6,}$/;
            if (!passwordRegex.test(password)) {
                alert("Password must contain at least one lowercase letter, one uppercase letter, one number, one special character, and be at least 6 characters long!");
                document.getElementById("password").focus();
                return false;
            }

            if (password !== confirm_password) {
                alert("Passwords do not match!");
                document.getElementById("confirm_password").focus();
                return false;
            }

            return true;
        }
    </script>
</body>
</html>

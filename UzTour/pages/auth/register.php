<?php

ini_set('display_errors', 0);  // Turn off error display
ini_set('log_errors', 1);      // Turn on error logging
ini_set('error_log', '/path/to/your/logs/php_error.log');  // Specify log file path

// Optional: Set the error reporting level to log all errors
error_reporting(E_ALL);

include '../../includes/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST["nickname"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $date_of_birth = $_POST["date_of_birth"];
    $login = $_POST["login"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone_number = $_POST["phone_number"];
    $profile_image = null; // Default value if no image is uploaded

    // Check if the passwords match
    if ($password === $_POST["repassword"]) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Handle file upload for profile image
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            // File upload path
            $upload_dir = '../../uploads/';
            $file_name = $_FILES['profile_image']['name'];
            $file_tmp = $_FILES['profile_image']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_exts = ['jpg', 'jpeg', 'png'];

            // Check file extension
            if (in_array($file_ext, $allowed_exts)) {
                $file_path = $upload_dir . uniqid() . '.' . $file_ext;
                move_uploaded_file($file_tmp, $file_path);
                $profile_image = $file_path; // Set profile image path
            } else {
                echo "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
                exit();
            }
        }

        // Prepare the SQL query to insert user data
        $stmt = $conn->prepare("INSERT INTO Users (nickname, firstname, lastname, date_of_birth, login, email, password, phone_number, profile_image) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $nickname, $firstname, $lastname, $date_of_birth, $login, $email, $hashed_password, $phone_number, $profile_image);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to home after successful registration
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Passwords do not match
        echo "Passwords do not match!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        main {
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        form input, form select, form textarea {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 48%; /* Input width adjusted for two-column layout */
        }
        form div input:nth-child(odd), form div select:nth-child(odd) {
            width: 48%;
        }
        form div input:nth-child(even), form div select:nth-child(even) {
            width: 48%;
        }
        #add-rasm-btn {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        #add-rasm-btn img {
            margin-right: 10px;
        }
        #form-btns {
            display: flex;
            justify-content: space-between;
        }
        #form-btns input {
            width: 48%;
            padding: 10px;
            cursor: pointer;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
        #form-btns input[type="reset"] {
            background-color: #f44336;
        }
        #login-btn p {
            text-align: center;
        }
    </style>
</head>
<body>
    <main>
        <section>
            <form action="register.php" method="POST" enctype="multipart/form-data">
                <p>Register</p>
                
                <!-- First section (nickname, firstname, lastname, date of birth) -->
                <div>
                    <input type="text" name="nickname" autocomplete="off" placeholder="Nickname*" required />
                    <input type="text" name="firstname" autocomplete="off" placeholder="First Name*" required />
                </div>
                <div>
                    <input type="text" name="lastname" autocomplete="off" placeholder="Last Name*" required />
                    <input type="date" name="date_of_birth" autocomplete="off" placeholder="Date of Birth*" required />
                </div>
                
                <!-- Second section (login, email, phone number, password, repeat password) -->
                <div>
                    <input type="text" name="login" autocomplete="off" placeholder="Login*" required />
                    <input type="email" name="email" autocomplete="off" placeholder="Email*" required />
                </div>
                <div>
                    <input type="text" name="phone_number" autocomplete="off" placeholder="Phone Number" />
                    <input type="password" name="password" autocomplete="off" placeholder="Password*" required />
                </div>
                <div>
                    <input type="password" name="repassword" autocomplete="off" placeholder="Repeat Password*" required />
                </div>

                <!-- Image upload section -->
                <div>
                    <button id="add-rasm-btn">
                        <img src="../../images/icons/download.png" />
                        <input type="file" name="profile_image" id="add-rasm" title="Profile Image" accept="image/jpeg, image/png, image/jpg" />
                    </button>
                </div>

                <!-- Clear and Register buttons -->
                <div id="form-btns">
                    <input type="reset" value="Clear" />
                    <input type="submit" value="Register" />
                </div>

                <!-- Login link -->
                <div id="login-btn">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

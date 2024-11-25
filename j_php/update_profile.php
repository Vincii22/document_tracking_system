<?php
require_once("../includes/initialize.php");

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect_to('login.php');
}

// Fetch the current user data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = {$user_id}";
$result = $database->query($query);
$user_data = $database->fetch_array($result);

if (!$user_data) {
    echo "User data not found.";
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $database->escape_value($_POST['username']);
    $first_name = $database->escape_value($_POST['first_name']);
    $last_name = $database->escape_value($_POST['last_name']);
    $email = $database->escape_value($_POST['email']);
    $user_abbreviation = $database->escape_value($_POST['user_abbreviation']);

    // Initialize password variable
    $password_hashed = $user_data['password']; // Retain old password by default

    // Check if password is provided and validate its strength
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];

        // Password strength validation
        $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/';

        if (!preg_match($password_pattern, $password)) {
            echo "<script>alert('Password does not meet the strength requirements.');</script>";
        } else {
            // Hash new password if provided
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);
        }
    }

    // Handle file upload for user_image if provided
    if (!empty($_FILES['user_image']['name'])) {
        $user_image = "../uploads/users/" . basename($_FILES['user_image']['name']);
        move_uploaded_file($_FILES['user_image']['tmp_name'], $user_image);
    } else {
        $user_image = $user_data['user_image']; // Retain old image if not changed
    }

    // Prepare the update query with all fields
    $update_query = "UPDATE users SET 
        username = '{$username}', 
        first_name = '{$first_name}', 
        last_name = '{$last_name}', 
        email = '{$email}', 
        user_abbreviation = '{$user_abbreviation}', 
        password = '{$password_hashed}', 
        user_image = '{$user_image}' 
        WHERE user_id = {$user_id}";

    // Execute the query
    $result = $database->query($update_query);

    if ($result) {
        // Show success message and redirect after 3 seconds
        echo "<script>
            window.onload = function() {
                setTimeout(function() {
                    document.getElementById('success-message-container').style.display = 'block';
                    setTimeout(function() {
                        window.location.href = '../public/profile.php';
                    }, 5000); // Redirect after 3 seconds
                }, 50); // Delay to show success message
            };
        </script>";
    } else {
        echo "<script>alert('Failed to update profile.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update Success</title>
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General page layout to ensure center alignment */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        /* Styling for the box container around the success message */
        .alert-container {
            display: none;
            background-color: #fff;
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 80%;
            max-width: 450px;
            text-align: center;
            animation: fadeIn 2s ease-in-out;
            position: relative;
        }

        /* Styling for the success message */
        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            font-size: 18px;
            border-radius: 5px;
            margin-bottom: 20px;
            animation: fadeIn 2s ease-in-out;
        }

        /* Positioning the check icon at the top center */
        .check-icon {
            font-size: 40px; /* Increased size for visibility */
            color: #4CAF50; /* Green color to match the success message */
            position: absolute;
            top: -30px; /* Adjusted for visibility */
            left: 50%;
            transform: translateX(-50%);
            animation: fadeInIcon 1s ease-in-out;
        }

        /* Fade-in effect for the check icon */
        @keyframes fadeInIcon {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Animation for fade-in effect */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Close button style */
        .close-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
        }

        .close-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <!-- Alert box container -->
    <div id="success-message-container" class="alert-container">
        <!-- Check icon -->
        <div class="check-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <!-- Success message -->
        <div id="success-message" class="success-message">
            Profile updated successfully! Redirecting you back to your profile...
        </div>
        <!-- Close button (optional) -->
        <!-- <button class="close-btn" onclick="window.location.href='../public/profile.php'">Close and Go to Profile</button> -->
    </div>
</body>
</html>

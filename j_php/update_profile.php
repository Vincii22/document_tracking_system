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
} else {
    echo "<pre>";
    print_r($user_data); // Debugging line
    echo "</pre>";
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
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update profile.');</script>";
    }
}

?>

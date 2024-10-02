<?php
require_once("../includes/initialize.php");

// Ensure the user is logged in
if (!isset($_SESSION['usertype'])) {
    redirect_to('login.php');
}

// Fetch notifications for the logged-in user
$user_id = $_SESSION['user_id'];
$notification_query = "SELECT * FROM notifications WHERE user_id = '{$user_id}' ORDER BY created_at DESC";
$notification_result = $database->query($notification_query);
$notifications = [];

// Mark notifications as read when fetched
$update_query = "UPDATE notifications SET status = 'READ' WHERE user_id = '{$user_id}' AND status = 'UNREAD'";
$database->query($update_query);

while ($row = $database->fetch_array($notification_result)) {
    $notifications[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Notifications</h2>
    <ul class="list-group">
        <?php foreach ($notifications as $notification): ?>
            <li class="list-group-item"><?php echo $notification['message']; ?>
                <small class="text-muted"><?php echo date('Y-m-d H:i', strtotime($notification['created_at'])); ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

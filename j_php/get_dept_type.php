<?php
require_once("../includes/initialize.php");

if (isset($_POST['dept_id'])) {
    $dept_id = $_POST['dept_id'];
    
    // Fetch dept_type for the given dept_id
    $query = "SELECT dept_type FROM departments WHERE dept_id = ?";
    $stmt = $database->prepare($query);
    $stmt->bind_param("i", $dept_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo $row['dept_type']; // Send dept_type back as response
    } else {
        echo "error";
    }
    $stmt->close();
} else {
    echo "error";
}
?>

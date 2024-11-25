<?php
// Assuming the form data is posted here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $remark_text = $_POST['remark_text'];
    $doc_id = $_POST['doc_id'];
    $department_name = $_POST['department_name'];

    // Insert the new remark into the database
    $insert_query = "INSERT INTO remarks (doc_id, department_name, remark_text) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($insert_query);
    $stmt->execute([$doc_id, $department_name, $remark_text]);

    // Redirect back to the document page or wherever needed
    header('Location: document_details.php?doc_id=' . $doc_id);
    exit;
}

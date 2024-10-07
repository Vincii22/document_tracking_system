<?php
require_once("../includes/initialize.php");

if (isset($_POST['doc_id'])) {
    $doc_id = $_POST['doc_id'];

    // Fetch the document using the provided document ID
    $document = Document::find_by_id($doc_id);

    if ($document instanceof Document) {
        // Output the document details as a JSON object
        echo json_encode([
            'doc_name' => $document->doc_name,
            'doc_owner' => $document->doc_owner,
            'doc_type' => $document->doc_type,
            'doc_file' => '/php/PreOral/uploads/' . $document->doc_file, // Assuming file path
            'date_started' => $document->date_started
        ]);
    } else {
        echo json_encode(['error' => 'Document not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>

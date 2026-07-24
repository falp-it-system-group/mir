<?php
require '../common/db_connection.php';

header('Content-Type: application/json');

$document_no = isset($_GET['document_no']) ? $_GET['document_no'] : '';

if (empty($document_no)) {
    $conn = null;
    exit("Must have document no to display checksheet form");
}

// Get checksheet template json
$sql = "EXEC chksht_GET_trd_question_label :documentNo";

$stmt = $conn->prepare($sql);

$stmt->bindValue(':documentNo', trim($document_no), PDO::PARAM_STR);

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $conn = NULL;
    exit("No Checksheet Template Found! Call IT Personnel Immediately!!!");
}

echo $row['question_label_json'];

$conn = NULL;

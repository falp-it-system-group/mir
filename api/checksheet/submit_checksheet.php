<?php
header('Content-Type: application/json');

$response = [
    "notification" => [
        "icon" => "error", // Default to an error message
        "text" => "An error occurred"
    ]
];

try {
    if (!isset($_POST)) {
        exit('checksheet json post not set! Call IT Personnel Immediately!!!');
    }

    $checksheetJson = json_encode($_POST);

    if (empty($checksheetJson)) {
        exit('checksheet json cannot be empty! Call IT Personnel Immediately!!!');
    }

    // database connection
    require '../common/db_connection.php';

    $sql = "EXEC chksht_ADD_trd_data :checksheetJson";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':checksheetJson', trim($checksheetJson), PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Success case
        $response['notification'] = [
            "icon" => "success",
            "text" => "Checksheet Submitted Successfully",
        ];
    } else {
        // Handle execution failure
        $response['notification']['text'] = "Add Item Failed";
    }
} catch (Exception $e) {
    // Catch any unexpected exceptions
    $response['notification']['text'] = "Error: " . $e->getMessage();
}

echo json_encode($response);

$conn = NULL;

<?php
require '../common/db_connection.php';

header('Content-Type: application/json');

$date_time_from = (new DateTime($_GET['date_time_from']))->format('Y-m-d H:i:s');
$date_time_to = (new DateTime($_GET['date_time_to']))->format('Y-m-d H:i:s');
$document_no = isset($_GET['document_no']) ? $_GET['document_no'] : '';
$car_model = isset($_GET['car_model']) ? $_GET['car_model'] : '';
$machine_no = isset($_GET['machine_no']) ? $_GET['machine_no'] : '';
$equipment_no = isset($_GET['equipment_no']) ? $_GET['equipment_no'] : '';

if (empty($document_no)) {
    $conn = null;
    exit("Must have document no to view checksheets");
}

try {
    $sql = "EXEC chksht_GET_trd_checksheets :date_time_from, :date_time_to, :documentNo, :carModel, :machineNo, :equipmentNo";

    $stmt = $conn->prepare($sql);

    $stmt -> bindValue(":date_time_from",trim($date_time_from));
    $stmt -> bindValue(":date_time_to",trim($date_time_to));

    $stmt->bindValue(':documentNo', trim($document_no), PDO::PARAM_STR);

    if (empty($car_model)) {
        $stmt->bindValue(':carModel', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':carModel', trim($car_model), PDO::PARAM_STR);
    }

    if (empty($machine_no)) {
        $stmt->bindValue(':machineNo', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':machineNo', trim($machine_no), PDO::PARAM_STR);
    }

    if (empty($equipment_no)) {
        $stmt->bindValue(':equipmentNo', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':equipmentNo', trim($equipment_no), PDO::PARAM_STR);
    }

    $stmt->execute();

    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Decode the JSON column
        $json = json_decode($row['checksheet_json'], true);

        // Remove the original JSON string
        unset($row['checksheet_json']);

        // Convert DateTime object to string if using sqlsrv
        if ($row['checksheet_date_time'] instanceof DateTime) {
            $row['checksheet_date_time'] = $row['checksheet_date_time']->format('Y-m-d H:i:s');
        }

        // Merge database columns with JSON fields
        $data[] = array_merge($row, $json);
    }

    $columns = [];

    if (isset($data[0])) {
        $columns = array_keys($data[0]);
    }

    $response = [
        "columns" => $columns,
        "data" => $data
    ];

    // Set header for JSON response
    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    // Handle exceptions and return an error message
    echo json_encode(['error' => $e->getMessage()]);
}

$conn = NULL;

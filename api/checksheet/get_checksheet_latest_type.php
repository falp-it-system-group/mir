<?php
    require '../common/db_connection.php';

    header('Content-Type: application/json');

    try {
        $sql = "EXEC chksht_GET_trd_latest_type";

        $stmt = $conn->prepare($sql);
        
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Set header for JSON response
        echo json_encode($data);
    } catch (Exception $e) {
        // Handle exceptions and return an error message
        echo json_encode(['error' => $e->getMessage()]);
    }

    $conn = NULL;

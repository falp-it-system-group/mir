<?php
    include '../common/db_connection_emp_mgt.php';
    include '../common/imports.php';
    include '../common/sessions.php';

    $sql = "EXEC employees_GET_employee :EmpNo";

    $stmt = $conn -> prepare($sql);

    $stmt -> bindValue(":EmpNo",trim($_POST['emp_no']));
    $stmt -> execute();

    if ($data = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $user_data = [
            'emp_no' => $data['emp_no'],
            'full_name' => $data['full_name'],
            'dept' => $data['dept'],
            'section' => $data['section'],
            'line_no' => $data['line_no'],
            'position' => $data['position']
        ];
        $_SESSION['user'] = $user_data;
        $notification = [
            "icon" => "success",
            "text" => "Login Successful",
        ];
        $_SESSION['notification'] = json_encode($notification);
        header("location: {$system}/pages/checksheet");
        exit();
    } else {
        $notification = [
            "icon" => "error",
            "text" => "Bad Employee No.",
        ];
        $_SESSION['notification'] = json_encode($notification);
        header("location: {$system}/pages/signin");
        exit();
    }
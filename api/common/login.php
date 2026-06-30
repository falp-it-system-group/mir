<?php
    include '../common/db_connection.php';
    include '../common/imports.php';
    include '../common/sessions.php';

    $sql = "EXEC user_GET_login :Username, :Password";

    $stmt = $conn -> prepare($sql);

    $stmt -> bindValue(":Username", trim($_POST['username']));
    $stmt -> bindValue(":Password",trim($_POST['password']));
    $stmt -> execute();

    if ($data = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $user_data = [
            'name' => $data['name'],
            'role' => $data['role']
        ];
        $_SESSION['user'] = $user_data;
        $notification = [
            "icon" => "success",
            "text" => "Login Successful",
        ];
        $_SESSION['notification'] = json_encode($notification);
        header("location: {$system}/pages/dashboard");
        exit();
    } else {
        $notification = [
            "icon" => "error",
            "text" => "Bad username and/or password",
        ];
        $_SESSION['notification'] = json_encode($notification);
        header("location: {$system}/pages/signin");
        exit();
    }
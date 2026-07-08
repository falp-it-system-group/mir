<?php
    include '../common/sessions.php';
    include '../common/consts.php';
    $_SESSION['user'] = null;

    $notification = [
        "icon" => "warning",
        "text" => "User logged out",
    ];

    $_SESSION['notification'] = json_encode($notification);
    header("location: {$system}/pages/signin");
    exit();
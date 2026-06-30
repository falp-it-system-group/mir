<?php
    include 'consts.php';

    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        $notification = [
            "icon" => "warning",
            "text" => "Login Required",
        ];
        $_SESSION['notification'] = json_encode($notification);
        header("location: {$system}/pages/signin");
        exit();
    }
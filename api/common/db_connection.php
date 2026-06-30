<?php
// MS SQL Server Connection

$servername = '172.25.112.131, 1433\SQLEXPRESS';
$username = 'SA';
$password = 'SystemGroup2018';
$database = 'mir';

// $servername = '172.25.116.188';
// $username = 'SA';
// $password = 'SystemGroup@2022';
// $database = 'mir';

try {
    $conn = new PDO ("sqlsrv:Server=$servername;Database=$database",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}

//end database
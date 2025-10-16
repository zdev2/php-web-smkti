<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit;
}
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK TI Bali Global Denpasar</title>
</head>
<body>
    
</body>
</html>
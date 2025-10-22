<?php
include_once __DIR__ . '/../connect.php';
include_once __DIR__ . '/../utils/utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'] ?? '';
    if (!$table) die("Table name missing");

    $data = $_POST;
    unset($data['table']);

    insertData($table, $data);

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
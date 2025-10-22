<?php
session_start();
include_once __DIR__ . '/../connect.php';
include_once __DIR__ . '/../utils/utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'] ?? '';
    if (!$table) die("Table name missing");

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) die("Invalid table");

    $data = $_POST;
    unset($data['table']);

    $last_id = insertData($table, $data);

    // write audit (record inserted)
    writeAudit('insert', $table, $last_id !== false ? $last_id : null, $data);

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../index.php'));
    exit;
}
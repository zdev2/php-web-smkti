<?php
require_once '../connect.php';

function insertData($table, $data) {
    global $conn;

    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    $types = str_repeat("s", count($data)); // assuming all data are strings

    $stmt = $conn->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
    $stmt->bind_param($types, ...array_values($data));
    $stmt->execute();
    $stmt->close();
}

function updateData($table, $data, $id) {
    global $conn;

    $setClause = implode(", ", array_map(fn($col) => "$col = ?", array_keys($data)));
    $types = str_repeat("s", count($data)) . "i"; // assuming all data are strings except id

    $stmt = $conn->prepare("UPDATE $table SET $setClause WHERE id = ?");
    $stmt->bind_param($types, ...array_merge(array_values($data), [$id]));
    $stmt->execute();
    $stmt->close();
}
?>
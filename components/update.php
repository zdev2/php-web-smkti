<?php
session_start();
require_once __DIR__ . '/../connect.php';
require_once __DIR__ . '/../utils/utils.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '../index.php'));
    exit;
}

$table = $_POST['table'] ?? '';
$id = $_POST['id'] ?? '';

if (empty($table) || empty($id) || !preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '../index.php'));
    exit;
}

$id = (int)$id;

// fetch before state
$before = null;
$sel = $conn->prepare("SELECT * FROM `" . str_replace("`","``",$table) . "` WHERE id = ? LIMIT 1");
if ($sel) {
    $sel->bind_param('i', $id);
    $sel->execute();
    $res = $sel->get_result();
    $before = $res ? $res->fetch_assoc() : null;
    $sel->close();
}

// build data excluding id and table
$data = [];
foreach ($_POST as $k => $v) {
    if (in_array($k, ['id','table'], true)) continue;
    $data[$k] = trim($v);
}

$ok = updateData($table, $data, $id);

// fetch after state
$after = null;
$sel2 = $conn->prepare("SELECT * FROM `" . str_replace("`","``",$table) . "` WHERE id = ? LIMIT 1");
if ($sel2) {
    $sel2->bind_param('i', $id);
    $sel2->execute();
    $res2 = $sel2->get_result();
    $after = $res2 ? $res2->fetch_assoc() : null;
    $sel2->close();
}

// write audit (include before/after)
writeAudit('update', $table, $id, ['before' => $before, 'after' => $after]);

$back = $_SERVER['HTTP_REFERER'] ?? '../index.php';
header('Location: ' . $back);
exit;
?>
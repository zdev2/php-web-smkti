<?php
session_start();
require_once __DIR__ . '/../connect.php';
require_once __DIR__ . '/../utils/utils.php';

// Accept GET or POST
$id = $_REQUEST['id'] ?? null;
$table = $_REQUEST['table'] ?? null;
$back = $_SERVER['HTTP_REFERER'] ?? '../index.php';

if (empty($id) || empty($table) || !preg_match('/^[0-9]+$/', $id) || !preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
    header('Location: ' . $back . (strpos($back, '?') === false ? '?deleted=0' : '&deleted=0'));
    exit;
}

$id = (int) $id;
$tableEscaped = str_replace('`', '``', $table);

// fetch before
$before = null;
$sel = $conn->prepare("SELECT * FROM `{$tableEscaped}` WHERE id = ? LIMIT 1");
if ($sel) {
    $sel->bind_param('i', $id);
    $sel->execute();
    $res = $sel->get_result();
    $before = $res ? $res->fetch_assoc() : null;
    $sel->close();
}

$sql = "UPDATE `{$tableEscaped}` SET deleted_at = NOW() WHERE id = ? AND (deleted_at IS NULL OR deleted_at = '0000-00-00 00:00:00') LIMIT 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Location: ' . $back . (strpos($back, '?') === false ? '?deleted=0' : '&deleted=0'));
    exit;
}

$stmt->bind_param('i', $id);
$ok = $stmt->execute();
$stmt->close();

// fetch after
$after = null;
$sel2 = $conn->prepare("SELECT * FROM `{$tableEscaped}` WHERE id = ? LIMIT 1");
if ($sel2) {
    $sel2->bind_param('i', $id);
    $sel2->execute();
    $res2 = $sel2->get_result();
    $after = $res2 ? $res2->fetch_assoc() : null;
    $sel2->close();
}

// write audit (before/after)
writeAudit('delete', $table, $id, ['before' => $before, 'after' => $after]);

header('Location: ' . $back . (strpos($back, '?') === false ? ($ok ? '?deleted=1' : '?deleted=0') : ($ok ? '&deleted=1' : '&deleted=0')));
exit;
?>
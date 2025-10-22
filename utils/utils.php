<?php
require_once __DIR__ . '/../connect.php';

function refValues(array &$arr){
    $refs = [];
    foreach ($arr as $k => &$v) { $refs[$k] = &$v; }
    return $refs;
}

/**
 * Insert data and return inserted id on success, false on failure.
 */
function insertData($table, $data) {
    global $conn;
    if (empty($table) || empty($data) || !is_array($data)) return false;

    $cols = array_map(fn($c) => "`" . str_replace("`","``",$c) . "`", array_keys($data));
    $columns = implode(", ", $cols);
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    $types = str_repeat("s", count($data));

    $sql = "INSERT INTO `" . str_replace("`","``",$table) . "` ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $values = array_values($data);
    array_unshift($values, $types);
    call_user_func_array([$stmt, 'bind_param'], refValues($values));
    $ok = $stmt->execute();
    if (!$ok) {
        $stmt->close();
        return false;
    }
    $last_id = $conn->insert_id;
    $stmt->close();
    return $last_id;
}

function updateData($table, $data, $id) {
    global $conn;
    if (empty($table) || empty($data) || !is_array($data) || !isset($id)) return false;

    $sets = [];
    foreach (array_keys($data) as $col) $sets[] = "`" . str_replace("`","``",$col) . "` = ?";
    $setClause = implode(", ", $sets);
    $types = str_repeat("s", count($data)) . "i";

    $sql = "UPDATE `" . str_replace("`","``",$table) . "` SET $setClause WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $values = array_values($data);
    $values[] = (int)$id;
    array_unshift($values, $types);
    call_user_func_array([$stmt, 'bind_param'], refValues($values));
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

/**
 * Write audit record to audit_log table.
 * $action: 'insert'|'update'|'delete'
 * $table: table name
 * $record_id: int|null
 * $payload: array or string (will be JSON encoded)
 */
function writeAudit($action, $table, $record_id = null, $payload = null) {
    global $conn;
    if (!in_array($action, ['insert','update','delete'])) return false;
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) return false;

    $user_id = null;
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (isset($_SESSION['user_id'])) $user_id = (int) $_SESSION['user_id'];

    $data_json = null;
    if (is_array($payload) || is_object($payload)) {
        $data_json = json_encode($payload, JSON_UNESCAPED_UNICODE);
    } else {
        $data_json = $payload !== null ? (string)$payload : null;
    }

    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? null;

    $stmt = $conn->prepare("INSERT INTO `audit_log` (user_id, action, table_name, record_id, data, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) return false;

    // bind as: i s s i s s s  -> but record_id may be null; we'll send 0 when null
    $uid = $user_id ?? 0;
    $rid = $record_id !== null ? (int)$record_id : 0;
    $stmt->bind_param('ississs', $uid, $action, $table, $rid, $data_json, $ip, $ua);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
?>
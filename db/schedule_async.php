<?php
require_once("../modules/class.php");
$userId = $_POST["user_id"];
$date = $_POST["date"];
$SQL = "SELECT id, start, end, content FROM post WHERE user_id = ? AND date = ? ORDER BY start ASC";
$pdo = new connect();
$data = $pdo->dmlAll($SQL,array($userId, $date));
$_POST["user_id"] = $_POST["date"] = "";

echo json_encode($data);
?>

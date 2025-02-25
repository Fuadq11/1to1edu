<?php

session_start(); 
require("../../conn.php");
extract($_POST);
date_default_timezone_set("Asia/Baku");


$exmne_id = $_SESSION['examineeSession']['exmne_id'];
$res = array();

$sql = "SELECT break_time  FROM sessions WHERE exam_id = '$exam_id' AND examin_id = '$exmne_id'";
$result = $conn->query($sql);
$data = $result->fetch(PDO::FETCH_ASSOC);

$current_time = new DateTime();
$end_time = new DateTime($data['break_time']);
$remaining_time = $end_time->getTimestamp() - $current_time->getTimestamp();

if ($remaining_time <= 0) {
    $remaining_time = 0;
}
$res["remaining_time"] = $remaining_time;
echo json_encode($res);
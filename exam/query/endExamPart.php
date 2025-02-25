<?php

session_start(); 
require("../../conn.php");
extract($_POST);
date_default_timezone_set("Asia/Baku");


$exmne_id = $_SESSION['examineeSession']['exmne_id'];
$res = array();
if($act == "endExamPart"){
$sql = $conn->query("UPDATE sessions SET current_part = (current_part + 1) 
WHERE exam_id = '$exam_id' AND examin_id = '$exmne_id'");
if($sql){
    $res["status"] = "success";

}else{
    $res["status"] = "error";
}
}else{
    $res["status"] = "error";
}
echo json_encode($res);
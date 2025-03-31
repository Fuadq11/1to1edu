<?php

session_start(); 
require("../../conn.php");
extract($_POST);
date_default_timezone_set("Asia/Baku");

$session_id = $_SESSION['examineeSession']['session_id'];
       

$exmne_id = $_SESSION['examineeSession']['exmne_id'];
$res = array();
$res["questionIds"]=array();
if($act == "selectQuestions"){
$sql = $conn->query("SELECT ea.quest_id FROM exam_answers ea INNER JOIN exam_question_tbl eq on ea.quest_id = eq.eqt_id WHERE ea.session_id = '$session_id' AND ea.axmne_id = '$exmne_id'");
if($sql->rowCount()>0){
   while($qIds = $sql->fetch(PDO::FETCH_ASSOC)){
        array_push($res["questionIds"],$qIds['quest_id']);
   }
   $res["status"] = "success";
}else{
    $res["status"] = "error";
}
}else{
    $res["status"] = "error";
}
echo json_encode($res);
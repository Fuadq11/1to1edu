<?php
 session_start(); 
 include("../conn.php");
 extract($_POST);

$exmne_id = $_SESSION['examineeSession']['exmne_id'];



if(!isset($act)&& $act!="save" && !isset($exmne_id) && !isset($question_id) && !isset($exam_id)) { $res = array("res" => "error"); }else{
$selExSession = $conn->query("SELECT session_id FROM sessions WHERE examin_id='$exmne_id' AND exam_id='$exam_id' AND exam_end_status=0 ORDER BY session_id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$session_id = $selExSession['session_id'];
$selAns = $conn->query("SELECT * FROM exam_answers WHERE axmne_id='$exmne_id' AND exam_id='$exam_id' AND quest_id = '$question_id' AND session_id = '$session_id'");


// if($selExAttempt->rowCount() > 0)
// {
// 	$res = array("res" => "alreadyTaken");
// }
if($selAns->rowCount() > 0)
{
	$updLastAns = $conn->query("UPDATE exam_answers SET exans_status='updated',exans_answer = '$answer' WHERE axmne_id='$exmne_id' AND exam_id='$exam_id' AND quest_id = '$question_id' AND session_id = '$session_id'");
	if($updLastAns)
	{
		
		$res = array("res" => "success");
	}
	else
	{
		$res = array("res" => "error");
	}
		
		
}
else
{

		
		$insAns = $conn->query("INSERT INTO exam_answers(axmne_id,exam_id,quest_id,exans_answer,session_id) VALUES('$exmne_id','$exam_id','$question_id','$answer','$session_id')");
		if($insAns)
		{
			$res = array("res" => "success");
		}
		else
		{
			$res = array("res" => "error");
		}

}



 
}

 echo json_encode($res);
 ?>


 
<?php 
 include("../../../conn.php");
 $target_dir = "../../../assets/images/question-images/";

extract($_POST);

$delExam = $conn->query("DELETE  FROM exam_question_tbl WHERE eqt_id='$id'  ");
$selQuestionImgs = $conn->query("SELECT *  FROM question_images WHERE question_id='$id'  ");

if($delExam)
{
	$res = array("res" => "success");
	if($selQuestionImgs->rowCount()>0){
		while ($img=$selQuestionImgs->fetch(PDO::FETCH_ASSOC)){
			$file = $target_dir.$img['img_name'];
			if(file_exists($file)){
				unlink($file);
			}
		}
		$delQuestionImgs = $conn->query("DELETE  FROM question_images WHERE question_id='$id'  ");
		if($delQuestionImgs){
			$res = array("res" => "success");
		}
	}else{
		$res = array("res" => "success");
	}
}
else
{
	$res = array("res" => "failed");
}


	echo json_encode($res);
 ?>
<?php 
 include("../../../conn.php");
$target_dir = "../../../assets/images/question-images/";
extract($_POST);

// $question_type=1;
// 0 - multiple choice
// 1 - open question


$selQuest = $conn->query("SELECT * FROM exam_question_tbl WHERE exam_id='$examId' AND exam_question='$question' ");
if($selQuest->rowCount() > 0)
{
  $res = array("res" => "exist", "msg" => $question);
}
else
{	
	if($question_type==0){
		$insQuest = $conn->prepare("INSERT INTO exam_question_tbl(exam_id,exam_question,question_detail,exam_ch1,exam_ch2,exam_ch3,exam_ch4,exam_answer,exam_part,question_type) 
				VALUES(?,?,?,?,?,?,?,?,?,?) ");
		$result = $insQuest->execute([$examId,$question,$question_detail,$choice_A,$choice_B,$choice_C,$choice_D,$correctAnswer,$question_for,$question_type]);
		$question_id = $conn->lastInsertId();
	}else{
	/* Open type question */
		$insQuest = $conn->prepare("INSERT INTO exam_question_tbl(exam_id,exam_question,question_detail,exam_answer,exam_part,question_type) 
									VALUES(?,?,?,?,?,?) ");
		$result = $insQuest->execute([$examId,$question,$question_detail,$correctAnswer,$question_for,$question_type]);
		$question_id = $conn->lastInsertId();
	}
	if($insQuest)
	{
       $res = array("res" => "success", "msg" => $question);
	   if(isset($_FILES['questionImage'])){
		$img_names = $_FILES['questionImage']['name'];
		$tmp_names = $_FILES['questionImage']['tmp_name'];
		
		$img_array = array_combine($tmp_names,$img_names);

		foreach($img_array as $tmp_name=>$img_name){
			$new_name = uniqid().'.'.pathinfo($img_name,PATHINFO_EXTENSION);			
			if(!move_uploaded_file($tmp_name,$target_dir.$new_name)){
				$res = array("res" => "failed");
			};
			
			if(isset($question_id)){
				$insertImage = $conn->query("INSERT INTO question_images (img_name,question_id) VALUES ('$new_name',$question_id)");

				if(!$insertImage){
					$res = array("res" => "failed");
				}
			}
		}
	}
	  
	}
	else
	{
       $res = array("res" => "failed");
	}
	
	
}



echo json_encode($res);
 ?>
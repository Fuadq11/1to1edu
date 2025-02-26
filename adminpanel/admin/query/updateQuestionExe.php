<?php
 include("../../../conn.php");
 $target_dir = "../../../assets/images/question-images/";
 extract($_POST);

if(isset($act) && $act == "delete"){
		$dlt_image = $conn->query("DELETE FROM question_images WHERE img_id = '$img_id' ");
		$file = $target_dir.$img_name;
		if($dlt_image)
		{
			if(file_exists($file)){
				unlink($file);
				$res = array("res" => "success");
			}else{
				$res = array("res" => "error");
			}
		}
		else
		{
			$res = array("res" => "error");
		}
 		echo json_encode($res);
}else if(isset($question_id) && !empty($question_id)){
	if($up_question_type==0){
		$updCourse = $conn->query("UPDATE exam_question_tbl SET exam_question='$up_question',question_detail='$up_question_detail', exam_ch1='$up_choice_A', exam_ch2='$up_choice_B', exam_ch3='$up_choice_C', exam_ch4='$up_choice_D',exam_answer='$up_correctAnswer',exam_part='$up_question_for',question_type='$up_question_type' WHERE eqt_id='$question_id' ");
	}else if($up_question_type==1){
		$updCourse = $conn->query("UPDATE exam_question_tbl SET exam_question='$up_question',question_detail='$up_question_detail', exam_ch1='', exam_ch2='', exam_ch3='', exam_ch4='',exam_answer='$up_correctAnswer',exam_part='$up_question_for',question_type='$up_question_type' WHERE eqt_id='$question_id' ");
	}
if($updCourse)
{
	   $res = array("res" => "success");
	   if(isset($_FILES['up_questionImage'])){
		$img_names = $_FILES['up_questionImage']['name'];
		$tmp_names = $_FILES['up_questionImage']['tmp_name'];
		
		$img_array = array_combine($tmp_names,$img_names);

		foreach($img_array as $tmp_name=>$img_name){
			$new_name = uniqid().'.'.pathinfo($img_name,PATHINFO_EXTENSION);			
			if(!move_uploaded_file($tmp_name,$target_dir.$new_name)){
				$res = array("res" => "failed");
			};
				$insertImage = $conn->query("INSERT INTO question_images (img_name,question_id) VALUES ('$new_name',$question_id)");

				if(!$insertImage){
					$res = array("res" => "failed");
				}
			
		}
	}
}
else
{
	   $res = array("res" => "failed");
}



 echo json_encode($res);	
}
?>
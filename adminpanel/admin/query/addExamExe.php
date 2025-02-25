<?php 
 include("../../../conn.php");

 extract($_POST);

 $selCourse = $conn->query("SELECT * FROM exam_tbl WHERE ex_title='$examTitle' ");

 if($courseSelected == "0")
 {
 	$res = array("res" => "noSelectedCourse");
 }
 else if($en_timeLimit == "0")
 {
 	$res = array("res" => "noSelectedEnTime");
 }
 else if($math_timeLimit == "0")
 {
 	$res = array("res" => "noSelectedMathTime");
 }else if($math_timeLimit_2 == "0")
 {
 	$res = array("res" => "noSelectedMathTime");
 }else if($en_timeLimit_2 == "0")
 {
 	$res = array("res" => "noSelectedEnTime");
 }
//  else if($examQuestDipLimit == "" && $examQuestDipLimit == null)
//  {
//  	$res = array("res" => "noDisplayLimit");
//  }
 else if($selCourse->rowCount() > 0)
 {
	$res = array("res" => "exist", "examTitle" => $examTitle);
 }
 else
 {
    if($exam_type==1){ // for SAT exam
		$insExam = $conn->query("INSERT INTO exam_tbl(cou_id,ex_title,ex_math_time_limit,ex_math_time_limit_2,ex_en_time_limit,ex_en_time_limit_2,ex_description,exam_type,exam_end_type) VALUES('$courseSelected','$examTitle','$math_timeLimit','$math_timeLimit_2','$en_timeLimit','$en_timeLimit_2','$examDesc','$exam_type','$exam_end_type') ");
		if($insExam)
		{
			$res = array("res" => "success", "examTitle" => $examTitle);
		}
		else
		{
			$res = array("res" => "failed", "examTitle" => $examTitle);
		}
	}


 }




 echo json_encode($res);
 ?>
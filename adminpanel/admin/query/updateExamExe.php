<?php 
 include("../../../conn.php");
 
 extract($_POST);

if(isset($act) && $act == "exam_status"){
  $updExam = $conn->query("UPDATE exam_tbl SET status = '$status' WHERE  ex_id='$ex_id' ");
  if($updExam)
  {
    $res = array("res" => "success", "msg" => "Status updated successfully");
  }
  else
  {
    $res = array("res" => "failed", "msg" => "Failed to update status");
  }
}else{
 $updExam = $conn->query("UPDATE exam_tbl SET 
                          cou_id='$courseId', 
                          ex_title='$examTitle', 
                          ex_math_time_limit='$math_timeLimit',
                          ex_math_time_limit_2='$math_timeLimit_2',
                          ex_en_time_limit='$en_timeLimit',
                          ex_en_time_limit_2='$en_timeLimit_2',
                          ex_description='$examDesc',
                          exam_type='$exam_type',
                          exam_end_type='$exam_end_type' 
                          WHERE  ex_id='$examId'");
  if($updExam)
  {
    $res = array("res" => "success", "msg" => $examTitle);
  }
  else
  {
    $res = array("res" => "failed");
  }
}

 echo json_encode($res);
 ?>
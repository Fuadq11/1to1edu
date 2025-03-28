<?php
 session_start(); 
 include("../conn.php");
 extract($_POST);
 date_default_timezone_set("Asia/Baku");


$exmne_id = $_SESSION['examineeSession']['exmne_id'];
$res = array();
$res["examstatus"] = 0;
$parts[1] = "en_time";
$parts[2] = "en_time_2";
$parts[3] = "math_time";
$parts[4] = "math_time_2";
$ex_part = $parts[$part];

$sql = "SELECT ".$ex_part."  FROM sessions WHERE exam_id = '$exam_id' AND examin_id = '$exmne_id' AND exam_end_status = 0";
$result = $conn->query($sql);
$data = $result->fetch(PDO::FETCH_ASSOC);

$current_time = new DateTime();
$end_time = new DateTime($data[$ex_part]);
$remaining_time = $end_time->getTimestamp() - $current_time->getTimestamp();
// $remaining_time = $data['math_time'];

if ($remaining_time <= 0) {
    $remaining_time = 0;
    // if($part == 1){
    //     $queryEndMathPart = $conn->query("UPDATE exam_attempt SET math_part_status = 1 WHERE exam_id = '$exam_id' AND exmne_id = '$exmne_id'");
    //     $res["examstatus"] = 1;
    // }else if($part == 2){
    //     $queryEndMathPart = $conn->query("UPDATE exam_attempt SET en_part_status = 1 WHERE exam_id = '$exam_id' AND exmne_id = '$exmne_id'");
    //     $res["examstatus"] = 2;
    // }
    $res["examstatus"] = $part;
    $part++;
    if($part==5){
        $queryEndExam = $conn->query("UPDATE sessions SET current_part = '$part',exam_end_status=1 WHERE exam_id = '$exam_id' AND examin_id = '$exmne_id' AND exam_end_status=0;
                                    UPDATE exam_attempt set examat_status = 1 WHERE exam_id = '$exam_id' AND exmne_id = '$exmne_id'");
    }else{
        $queryChangePart = $conn->query("UPDATE sessions SET current_part = '$part' WHERE exam_id = '$exam_id' AND examin_id = '$exmne_id' AND exam_end_status=0");
    }

}
$res["remaining_time"] = $remaining_time;
echo json_encode($res);





 ?>


 
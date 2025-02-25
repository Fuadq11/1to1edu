<?php 
require "../conn.php";
session_start();
$examin_id = $_SESSION['examineeSession']['exmne_id'];
extract($_POST);
$act = htmlspecialchars($act);
$resp = array();
$resp['status']="error";
$resp['exams'] = array();
if(isset($act) && empty($act)==false && $act == 'exams'){


$selExmneeData = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_id='$examin_id' ")->fetch(PDO::FETCH_ASSOC);
$exmneCourse =  $selExmneeData['exmne_course'];
    // echo "<option>Select Category</option>";
$res= $conn->query("select * from exam_tbl WHERE exam_type = '$exam_type' and cou_id = '$exmneCourse' and status = 1 and ex_id not in (SELECT exam_id FROM exam_attempt WHERE exmne_id = '$examin_id') order by ex_id desc"); 
        if($res->rowCount()>0){
            while($data=$res->fetch(PDO::FETCH_ASSOC))
            {
            // echo "<option value='".$data['ex_id']."'>.".$data['ex_title']."</option>";
            array_push($resp['exams'],['id'=>$data['ex_id'],'name'=>$data['ex_title']]);
            }
            $resp['status']="success";
            
        }else{
            $resp['status']="empty";
        }
    }else{
        $resp['status']="error";
    }
    echo json_encode($resp);
    
?>
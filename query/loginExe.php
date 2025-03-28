<?php 
session_start();
 include("../conn.php");
 

extract($_POST);
$username = htmlspecialchars($username);
$pass = htmlspecialchars($pass);
$selAcc = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_email='$username' AND exmne_password='$pass' AND exmne_status = 'active' ");
$selAccRow = $selAcc->fetch(PDO::FETCH_ASSOC);


if($selAcc->rowCount() > 0)
{
  $_SESSION['examineeSession'] = array(
  	 'exmne_id' => $selAccRow['exmne_id'],
  	 'exmne_fullname' => $selAccRow['exmne_fullname'],
  	 'examineenakalogin' => true
  );
  $res = array("res" => "success");

}
else
{
  $res = array("res" => "invalid");
}




 echo json_encode($res);
 ?>
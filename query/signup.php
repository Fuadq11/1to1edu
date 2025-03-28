<?php 
 include("../conn.php");


extract($_POST);

// $selExamineeFullname = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_fullname='$fullname' ");
$selExamineeEmail = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_email='$email' ");


if($gender == "0")
{
	$res = array("res" => "noGender");
}
else if(empty($email) || !isset($email)){
	$res = array("res" => "noEmail");
	
}
// else if($selExamineeFullname->rowCount() > 0)
// {
// 	$res = array("res" => "fullnameExist", "msg" => $fullname);
// }
else if($selExamineeEmail->rowCount() > 0)
{
	$res = array("res" => "emailExist", "msg" => $email);
}
else
{
	$insData = $conn->query("INSERT INTO examinee_tbl(exmne_fullname,exmne_course,exmne_gender,exmne_birthdate,exmne_email,exmne_password,exmne_status) VALUES('$fullname','-1','$gender','$bdate','$email','$password','pending')  ");
	if($insData)
	{
		$res = array("res" => "success", "msg" => $email);
	}
	else
	{
		$res = array("res" => "failed");
	}
}


echo json_encode($res);
 ?>
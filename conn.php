<?php 

$host = "localhost";
$user = "httpdfvv";
$pass = "VzrN8-7tfss*";
$db   = "httpdfvv_1to1edu";
$conn = null;

try {
  $conn = new PDO("mysql:host={$host};dbname={$db};",$user,$pass);
} catch (Exception $e) {
  
}


 ?>
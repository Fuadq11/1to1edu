<?php 
 
if(!isset($_GET['id']) || empty($_GET['id'])){
    echo "<h1>Error 404. Page not found</h1>";
 }else{
    $examId = $_GET['id'];
    date_default_timezone_set("Asia/Baku");
    require "../conn.php";
    session_start();
    if(!isset($_SESSION['examineeSession']['exmne_id']) || empty($_SESSION['examineeSession']['exmne_id']) || !isset($_GET['id']) || empty($_GET['id'])){
    echo "<h1>Error 404. Page not found</h1>";

    }else{
   
    $exmne_id = $_SESSION['examineeSession']['exmne_id'];
   
    if(!isset($_SESSION['examSession']['end_type']) || !isset($_SESSION['examSession']['part'])){
        $queryExam = $conn->query("SELECT * FROM exam_tbl where ex_id = '$examId'")->fetch(PDO::FETCH_ASSOC);
        $end_type = $queryExam['exam_end_type'];
    }else{
        $end_type = $_SESSION['examSession']['end_type'];
    }
    $queryExamTime = $conn->query("SELECT * FROM sessions WHERE exam_id='$examId' AND examin_id = '$exmne_id' ")->fetch(PDO::FETCH_ASSOC);
    if($queryExamTime['break_time']==NULL){
        $current_time = new DateTime('NOW');
        $current_time->add(DateInterval::createFromDateString('1 minute'));
        $current_time = (string) $current_time->format("Y-m-d H:i:s");
        $insertExamTime = $conn->query("UPDATE sessions SET break_time = ('$current_time') WHERE exam_id = '$examId'AND examin_id = '$exmne_id'");
      
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Break time</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body{
            background-color: black;
            color: #fff;
            height: 100vh;
            width: 100%;
        }
        main{
            height: 100vh;
        }
        main>div{
            height: 100vh;
        }
        .break-time{
            border: 1px solid #fff;
            border-radius: 10px;
            padding: 10px;

        }
        .break-time span{
            font-size: 18px;
        }
        #global_watch{
            font-size: 28px;
            text-align: center;
        }
        .resume-btn{
            margin-top: 20px;
            padding: 10px 20px;
            background-color: yellow;
            color: #000;
            border-radius: 20px;
            text-decoration: none;
        }
        .resume-btn:hover{
            text-decoration: none;
        }
        .content{
            text-align: center;
        }
    </style>
</head>
<body>
    <main>
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row">
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <div class="content">
                        <div class="break-time mb-4">
                            <span>Remaining Break Time:</span>
                            <p id="global_watch">00:00</p>
                        </div>
                       
                            <a href="index.php?page=exam&id=<?=$examId?>" class="resume-btn mt-5">Resume Testing</a>
                        
                    </div> 
                </div>
                <div class="col-6 d-flex justify-content-center align-items-center">
                        <div class="break-time-text">
                            <h1>Practice Test Break</h1>
                            <p>You can resume this practice test as soon as you're ready to move on</p>
                        </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../js/jquery.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js" ></script>
    <script>
        var exam_id = <?=$examId?>;
$(document).ready(function(){
    function updateCountdown() {
    $.ajax({
		url: "query/breakTimeChecker.php",
        method: 'post',
		data: {exam_id: exam_id},
		dataType : "json",
        success: function(data) {
			
			// data = JSON.parse(data);
            let remainingTime = data.remaining_time;
            if (remainingTime <= 0) {
				document.getElementById("global_watch").innerHTML = "Time is up!";
                window.location.href="index.php?page=exam&id="+exam_id;
				

            } else {
				
                let minutes = Math.floor(remainingTime / 60);

                let seconds = remainingTime % 60;
                document.getElementById("global_watch").innerHTML = `${minutes} : ${seconds}`;
                setTimeout(updateCountdown, 1000);
            }
		},
		error: function(error){
			console.error("Error:", error.responseText);
		}
        })
        
}

updateCountdown();
            });
    </script>
</body>
</html>
<?php } } ?>
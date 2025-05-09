 <?php 
 if( isset($_GET['s_id']) && empty($_GET['s_id'])==false){
    
    $session_id = $_GET['s_id'];
    $selSessions = $conn->query("SELECT * FROM sessions WHERE session_id='$session_id' ");
    
    if($selSessions->rowCount()>0){
    $selSession = $selSessions->fetch(PDO::FETCH_ASSOC);
    
    $examId = $selSession['exam_id'];
    $exmneId = $selSession['examin_id'];
    $selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$examId' ")->fetch(PDO::FETCH_ASSOC);
    $selExamin = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_id='$exmneId' ")->fetch(PDO::FETCH_ASSOC);

    function answer($typ,$answ){
        if($typ == 0){
            switch($answ){
                case "a": return "exam_ch1";break;
                case "b": return "exam_ch2";break;
                case "c": return "exam_ch3";break;
                case "d": return "exam_ch4";break;
                default: return "";
            }
        }else{
            return "exam_answer";
        }
    }
 ?>

<div class="app-main__outer">
<div class="app-main__inner">
    <div id="refreshData">
            
    <div class="col-md-12">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>
                        <?php echo $selExam['ex_title']; ?>
                          <div class="page-title-subheading">
                            <?php echo $selExam['ex_description']; ?>
                          </div>

                    </div>
                </div>
            </div>
        </div>  
        <div class="row col-md-12 pl-4">
        	<h1 class="text-primary "><?=$selExamin['exmne_fullname']?> Exam Result</h1>
        </div>
        
        <div class="col-md-8 float-left">
        	<div class="main-card mb-3 card">
                <div class="card-body">
                	<h5 class="card-title">Your Answers</h5>
                    
        			<table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <?php
                            $arr[1]="Section 1, Module 1: Reading and Writing";
                            $arr[2]="Section 1, Module 2: Reading and Writing";
                            $arr[3]="Section 2, Module 1: Math";
                            $arr[4]="Section 2, Module 2: Math";
                            for($k=1;$k<=4;$k++){   
                        ?>
                        <tr><td><h3><?=$arr[$k]?></h3></td></tr>
                    <?php 
                        // Section 1, Module 1: Reading and Writing
                    	$selQuest = $conn->query("SELECT * FROM exam_question_tbl eqt LEFT JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND ea.axmne_id='$exmneId' AND ea.session_id = '$session_id' WHERE eqt.exam_id='$examId' AND eqt.exam_part = '$k' Order by eqt.eqt_id ASC; ");
                    	// $selQuest = $conn->query("SELECT * FROM exam_question_tbl eqt LEFT JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id WHERE eqt.exam_id='$examId' AND ea.axmne_id='$exmneId' AND ea.session_id = '$session_id' ");
                    	$i = 1;
                        
                    	while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { ?>
                    		<tr>
                    			<td>
                    				<b><p><?php echo $i++; ?> .) <?php echo $selQuestRow['exam_question']; ?></p></b>
                    				<label class="pl-4 text-success">
                    					 
                                    <?php 
                                        if (isset($selQuestRow['exans_answer'])) {
                                            // Clean and compare answers
                                            $userRaw = strtolower(trim($selQuestRow['exans_answer']));
                                            $correctRaw = strtolower(trim($selQuestRow['exam_answer']));

                                            // Display-friendly formatted answers
                                            $userFormatted = $selQuestRow[answer($selQuestRow['question_type'], $selQuestRow['exans_answer'])];
                                            $correctFormatted = $selQuestRow[answer($selQuestRow['question_type'], $selQuestRow['exam_answer'])];

                                            $isCorrect = $userRaw === $correctRaw;
                                            $alertClass = $isCorrect ? 'alert-success' : 'alert-danger';
                                            $statusText = $isCorrect ? 'Correct' : 'Wrong';
                                            ?>

                                            <div class="alert <?php echo $alertClass; ?> shadow-sm rounded-3 p-3">
                                                <p class="mb-1"><strong>Your Answer:</strong> <?php echo $userFormatted; ?></p>
                                                <p class="mb-1 text-<?php echo $isCorrect ? 'success' : 'danger'; ?>"><strong>– <?php echo $statusText; ?></strong></p>
                                                <p class="mb-0"><strong>Correct Answer:</strong> <?php echo $correctFormatted; ?></p>
                                            </div>

                                        <?php 
                                        } else { ?>
                                            <div class="alert alert-info shadow-sm rounded-3 p-3">
                                                <p class="mb-0 text-primary"><strong>Not answered</strong></p>
                                            </div>
                                        <?php } ?>
                    				</label>
                    			</td>
                    		</tr>
                    	<?php } }
                     ?>
	                 </table>
                </div>
            </div>
        </div>

        <div class="col-md-4 float-left">
        	<div class="col-md-12 float-left">
        	<div class="card mb-3 widget-content bg-night-fade">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><h4>Reading and Writing Score</h4></div>
                        <div class="widget-subheading" style="color: transparent;">/</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <?php 
                                $selMathScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))  WHERE eqt.exam_part in (3,4) AND ea.axmne_id='$exmneId' AND ea.exam_id='$examId' and ea.session_id = '$session_id' ");
                                $selEnScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))  WHERE eqt.exam_part in (1,2) AND ea.axmne_id='$exmneId' AND ea.exam_id='$examId' and ea.session_id = '$session_id' ");
                                $selAllMathQuestions = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_tbl et ON eqt.exam_id = et.ex_id WHERE eqt.exam_part in (3,4)");
                                $selAllEnQuestions = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_tbl et ON eqt.exam_id = et.ex_id WHERE eqt.exam_part in (1,2)");
                                $rightMathCount =$selMathScore->rowCount();
                                $rightEnCount =$selEnScore->rowCount();
                                $allMathquestions = $selAllMathQuestions->rowCount();
                                $allEnquestions = $selAllEnQuestions->rowCount();
                                $math_score = ($rightMathCount / $allMathquestions) * 600;
                                $math_score = 200+ ceil($math_score / 10) * 10;
                                $en_score = ($rightEnCount / $allEnquestions) * 600;
                                $en_score = 200+ ceil($en_score / 10) * 10;
                                $math_score = $math_score>800? 800:$math_score;
                                $en_score = $en_score>800? 800:$en_score;

                                $total_score = $math_score + $en_score;
                            ?>
                           <span><?=$en_score?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3 widget-content bg-night-fade">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><h4>Math Score</h4></div>
                        <div class="widget-subheading" style="color: transparent;">/</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            
                            <span><?=$math_score?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3 widget-content bg-strong-bliss">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><h4>Total Score</h4></div>
                        <div class="widget-subheading" style="color: transparent;">/</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            
                            <span><?=$total_score?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3 widget-content bg-happy-itmeo">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading" style="width: 85%;"><h4>Reading and Writing Correct Answers</h4></div>
                        <div class="widget-subheading" style="color: transparent;">/</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            
                            <span><?=$rightEnCount?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3 widget-content bg-happy-itmeo">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><h4>Math Correct Answers</h4></div>
                        <div class="widget-subheading" style="color: transparent;">/</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            
                            <span><?=$rightMathCount?></span>
                        </div>
                    </div>
                </div>
            </div>
        	</div>

            
        </div>
    </div>


    </div>
</div>
<?php }else{ ?>
    <script>
        window.location.href="index.php";
    </script>

<?php 
} ?>
<?php }else{ ?>
    <script>
        window.location.href="index.php";
    </script>

<?php 
} ?>
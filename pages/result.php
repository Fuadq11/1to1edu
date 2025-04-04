 <?php 
 if(isset($_GET['id']) && empty($_GET['id'])==false && isset($_GET['s_id']) && empty($_GET['s_id'])==false){
    $examId = $_GET['id'];
    $session_id = $_GET['s_id'];
    $selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$examId' ")->fetch(PDO::FETCH_ASSOC);

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
        	<h1 class="text-primary ">RESULT'S</h1>
        </div>

        <div class="col-md-8 float-left">
        	<div class="main-card mb-3 card">
                <div class="card-body">
                	<h5 class="card-title">Your Answer's</h5>
        			<table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                    <?php 
                    	$selQuest = $conn->query("SELECT * FROM exam_question_tbl eqt LEFT JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND ea.axmne_id='$exmneId' AND ea.session_id = '$session_id' WHERE eqt.exam_id='$examId'  ");
                    	// $selQuest = $conn->query("SELECT * FROM exam_question_tbl eqt LEFT JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id WHERE eqt.exam_id='$examId' AND ea.axmne_id='$exmneId' AND ea.session_id = '$session_id' ");
                    	$i = 1;
                    	while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { ?>
                    		<tr>
                    			<td>
                    				<b><p><?php echo $i++; ?> .) <?php echo $selQuestRow['exam_question']; ?></p></b>
                    				<label class="pl-4 text-success">
                    					 
                    					<?php if(isset($selQuestRow['exans_answer'])){
                    						if(strtolower(trim($selQuestRow['exam_answer'])) != strtolower(trim($selQuestRow['exans_answer'])))
                    						{ ?>
                    							<span style="color:red"><?php echo "Your Answer: ".$selQuestRow['exans_answer']." | Wrong<br> <strong>Answer is: ".$selQuestRow['exam_answer']."</strong>"; ?></span>
                    						<?PHP }
                    						else
                    						{ ?>
                    							<span class="text-success"><?php echo "Your Answer: ".$selQuestRow['exans_answer']." | Correct<br> <strong>Answer is: ".$selQuestRow['exam_answer']."</strong>"; ?></span>
                    						<?php } }else{ ?>
                                                <span style="color:blue"><?php echo "Not answered"; ?></span>
                                         <?php   }
                    					 ?>
                    				</label>
                    			</td>
                    		</tr>
                    	<?php }
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
                                $math_score = ($rightMathCount / $allMathquestions) * 800;
                                $math_score = 200+ ceil($math_score / 10) * 10;
                                $en_score = ($rightEnCount / $allEnquestions) * 800;
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
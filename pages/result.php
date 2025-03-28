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
                    	$selQuest = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id WHERE eqt.exam_id='$examId' AND ea.axmne_id='$exmneId' AND ea.session_id = '$session_id' ");
                    	$i = 1;
                    	while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { ?>
                    		<tr>
                    			<td>
                    				<b><p><?php echo $i++; ?> .) <?php echo $selQuestRow['exam_question']; ?></p></b>
                    				<label class="pl-4 text-success">
                    					Answer : 
                    					<?php 
                    						if(strtolower(trim($selQuestRow['exam_answer'])) != strtolower(trim($selQuestRow['exans_answer'])))
                    						{ ?>
                    							<span style="color:red"><?php echo $selQuestRow['exans_answer']; ?></span>
                    						<?PHP }
                    						else
                    						{ ?>
                    							<span class="text-success"><?php echo $selQuestRow['exans_answer']; ?></span>
                    						<?php }
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
                        <div class="widget-heading"><h5>Score</h5></div>
                        <div class="widget-subheading" style="color: transparent;">/</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <?php 
                                $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))  WHERE ea.axmne_id='$exmneId' AND ea.exam_id='$examId' and ea.session_id = '$session_id' ");
                                $selAllQuestions = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_tbl et ON eqt.exam_id = et.ex_id");
                                $rightCount =$selScore->rowCount();
                                $allquestions = $selAllQuestions->rowCount();
                                $score = ($rightCount / $allquestions) * 800;
                                $score = ceil($score / 10) * 10;

                            ?>
                            <span><?=$score?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3 widget-content bg-happy-itmeo">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><h5>Correct Answers</h5></div>
                        <div class="widget-subheading" style="color: transparent;">/</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <?php 
                                $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))  WHERE ea.axmne_id='$exmneId' AND ea.exam_id='$examId' AND ea.session_id = '$session_id' ");
                                $rightCount =$selScore->rowCount();   

                            ?>
                            <span><?=$rightCount?></span>
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
<link rel="stylesheet" type="text/css" href="css/mycss.css">
<div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>EXAMINEE RESULT</div>
                    </div>
                </div>
            </div>        
            
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Examinee Result
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                            <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Exam Name</th>
                                <th>Attempt</th>
                                <th>Reading and Writing Scores</th>
                                <th>Math Scores</th>
                                <th>Total Scores</th>
                                <!-- <th>Ratings</th> -->
                                <th width="10%">Print</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $selExmne = $conn->query("SELECT *  FROM examinee_tbl et WHERE exmne_id = ANY (SELECT examin_id FROM sessions  WHERE  exam_end_status = 1) ");
                                
                                if($selExmne->rowCount() > 0)
                                {   
                                    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { 
                                        $eid = $selExmneRow['exmne_id'];
                                        $selExmneSessions = $conn->query("SELECT * FROM examinee_tbl et INNER JOIN sessions ea ON et.exmne_id = ea.examin_id WHERE et.exmne_id='$eid' AND ea.exam_end_status = 1 ORDER BY ea.exam_id DESC,ea.session_id DESC ");
                                        $i=$selExmneSessions->rowCount();
                                        while($selExmneSession = $selExmneSessions->fetch(PDO::FETCH_ASSOC)){
                                            
                                        
                                        $session_id = $selExmneSession['session_id'];
                                        ?>
                                        <tr>
                                           <td><?php echo $selExmneRow['exmne_fullname']; ?></td>
                                           <td>
                                             <?php 
                                                
                                                $selExName = $conn->query("SELECT * FROM exam_tbl et INNER JOIN sessions ea ON et.ex_id=ea.exam_id WHERE  ea.examin_id='$eid' ")->fetch(PDO::FETCH_ASSOC);
                                                $exam_id = $selExName['ex_id'];
                                                echo $selExName['ex_title'];
                                              ?>
                                           </td>
                                           <td>
                                                <?=$i--?>
                                            </td>
                                           <td>
                                                    <?php 
                                                    $selMathScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))  WHERE eqt.exam_part in (3,4) AND ea.axmne_id='$eid' AND ea.exam_id='$exam_id'AND ea.session_id ='$session_id'  ORDER BY ea.exans_id DESC ");
                                                    $selEnScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))  WHERE eqt.exam_part in (1,2) AND ea.axmne_id='$eid' AND ea.exam_id='$exam_id'AND ea.session_id ='$session_id'  ORDER BY ea.exans_id DESC ");
                                                    $selAllMathQuestions = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_tbl et ON eqt.exam_id = et.ex_id WHERE eqt.exam_part in (3,4)");
                                                    $selAllEnQuestions = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_tbl et ON eqt.exam_id = et.ex_id WHERE eqt.exam_part in (1,2)");
                                                    $rightMathAnswers =$selMathScore->rowCount();
                                                    $rightEnAnswers =$selEnScore->rowCount();
                                                    $allMathquestions = $selAllMathQuestions->rowCount();
                                                    $allEnquestions = $selAllEnQuestions->rowCount();
                                                    $math_score = ($rightMathAnswers / $allMathquestions) * 800;
                                                    $math_score = 200+ ceil($math_score / 10) * 10;
                                                    
                                                    $en_score = ($rightEnAnswers / $allEnquestions) * 800;
                                                    $en_score = 200+ ceil($en_score / 10) * 10;

                                                    $math_score = $math_score>800? 800:$math_score;
                                                    $en_score = $en_score>800? 800:$en_score;
                                                    $total_score = $en_score + $math_score
                                                      ?>
                                                <?php echo $en_score; ?>
                                           </td>
                                            <td>
                                                <?=$math_score?>
                                            </td>
                                            <td>
                                                <?=$total_score?>
                                            </td>
                                           <td>
                                               <button class="btn btn-sm btn-primary" onclick="generatePDF('<?=$selExmneRow['exmne_fullname']?>','<?=$selExName['ex_title']?>','<?=$en_score?>','<?=$math_score?>','<?=$total_score?>')">Print Result</button>

                                           </td>
                                        </tr>
                                    <?php }}
                                }
                                else
                                { ?>
                                    <tr>
                                      <td colspan="2">
                                        <h3 class="p-3">No Course Found</h3>
                                      </td>
                                    </tr>
                                <?php }
                               ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
      
        
</div>
         


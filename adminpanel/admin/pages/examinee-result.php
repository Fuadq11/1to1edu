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
                                <th>Scores</th>
                                <!-- <th>Ratings</th> -->
                                <th width="10%">Print</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $selExmne = $conn->query("SELECT * FROM examinee_tbl et INNER JOIN sessions ea ON et.exmne_id = ea.examin_id WHERE ea.exam_end_status = 1 ORDER BY ea.exam_id DESC,ea.session_id DESC ");
                                if($selExmne->rowCount() > 0)
                                {   $i=$selExmne->rowCount();
                                    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { 
                                        $session_id = $selExmneRow['session_id'];
                                        ?>
                                        <tr>
                                           <td><?php echo $selExmneRow['exmne_fullname']; ?></td>
                                           <td>
                                             <?php 
                                                $eid = $selExmneRow['exmne_id'];
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
                                                    $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))  WHERE ea.axmne_id='$eid' AND ea.exam_id='$exam_id'AND ea.session_id ='$session_id'  ORDER BY ea.exans_id DESC ");
                                                    $selAllQuestions = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_tbl et ON eqt.exam_id = et.ex_id");
                                                    $rightAnswers =$selScore->rowCount();
                                                    $allquestions = $selAllQuestions->rowCount();
                                                    $score = ($rightAnswers / $allquestions) * 800;
                                                    $score = ceil($score / 10) * 10;
                                                      ?>
                                                <?php echo $score; ?>
                                           </td>
                                          
                                           <td>
                                               <button class="btn btn-sm btn-primary" onclick="generatePDF('<?=$selExmneRow['exmne_fullname']?>','<?=$selExName['ex_title']?>','<?=$score?>')">Print Result</button>

                                           </td>
                                        </tr>
                                    <?php }
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
         


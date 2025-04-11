
<div class="app-main__outer">
        <div class="app-main__inner">
             


            <?php 
                @$exam_id = $_GET['exam_id'];


                if($exam_id != "")
                {
                   $selEx = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$exam_id' ")->fetch(PDO::FETCH_ASSOC);
                   $exam_course = $selEx['cou_id'];

                   

                   $selExmne = $conn->query("SELECT * FROM examinee_tbl et  WHERE et.exmne_course='$exam_course' ");
                  


                   ?>
                   <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div><b class="text-primary">RANKING BY EXAM</b><br>
                                Exam Name : <?php echo $selEx['ex_title']; ?><br><br>
                               <span class="border" style="padding:10px;color:black;background-color: yellow;">Excellent</span>
                               <span class="border" style="padding:10px;color:white;background-color: green;">Very Good</span>
                               <span class="border" style="padding:10px;color:white;background-color: blue;">Good</span>
                               <span class="border" style="padding:10px;color:white;background-color: red;">Failed</span>
                               <span class="border" style="padding:10px;color:black;background-color: #E9ECEE;">Not Answering</span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover display" id="tableListExamins">
                            <thead>
                                <tr>
                                    <th width="25%">Fullname</th>
                                    <th>Attempt</th>
                                    <th>Reading and Writing Score</th>
                                    <th>Math Score</th>
                                    <th>Total Score</th>
                                    <th>Reading and Writing (Correct / Over)</th>
                                    <th>Math (Correct / Over)</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { 
                                    $exmneId = $selExmneRow['exmne_id'];
                                    $selExmneSessions = $conn->query("SELECT * FROM  sessions WHERE examin_id='$exmneId' AND exam_id = '$exam_id' AND exam_end_status = 1 ORDER BY session_id DESC ");
                                    if($selExmneSessions->rowCount()==0){ ?>
                                        <tr style="background-color: #E9ECEE;color:black">
                                            <td><?=$selExmneRow['exmne_fullname'];?></td>
                                            <td colspan="4">Didn't take exam</td>
                                        </tr>

                                    <?php }else{
                                        $i=$selExmneSessions->rowCount();
                                    while ($selExmneSession = $selExmneSessions->fetch(PDO::FETCH_ASSOC)) { 
                                        
                                    $session_id = $selExmneSession['session_id'];
                                    
                                    ?>
                                    <?php 
                                            

                                            $selMathScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))  WHERE eqt.exam_part in (3,4) AND ea.axmne_id='$exmneId' AND ea.exam_id='$exam_id' AND ea.session_id = '$session_id' ORDER BY ea.exans_id DESC ");
                                            $selEnScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))  WHERE eqt.exam_part in (1,2) AND ea.axmne_id='$exmneId' AND ea.exam_id='$exam_id' AND ea.session_id = '$session_id' ORDER BY ea.exans_id DESC ");
                                            $selAllMathQuestions = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_tbl et ON eqt.exam_id = et.ex_id WHERE eqt.exam_part in (3,4)");
                                            $selAllEnQuestions = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_tbl et ON eqt.exam_id = et.ex_id WHERE eqt.exam_part in (1,2)");
                                            $rightMathAnswers =$selMathScore->rowCount();
                                            $rightEnAnswers =$selEnScore->rowCount();
                                            $allMathquestions = $selAllMathQuestions->rowCount();
                                            $allEnquestions = $selAllEnQuestions->rowCount();
                                            $math_score = ($rightMathAnswers / $allMathquestions) * 600;
                                            $math_score = 200+ ceil($math_score / 10) * 10;
                                            $en_score = ($rightEnAnswers / $allEnquestions) * 600;
                                            $en_score = 200+ ceil($en_score / 10) * 10;
                                           
                                            // $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer  WHERE ea.axmne_id='$exmneId' AND ea.exam_id='$exam_id' AND ea.exans_status='new' ORDER BY ea.exans_id DESC");
                                            $math_score = $math_score>800? 800:$math_score;
                                            $en_score = $en_score>800? 800:$en_score;
                                            $total_score = $en_score+$math_score;

                                         ?>
                                       <tr style="<?php 
                                             
                                            if($total_score >= 1400)
                                             {
                                                echo "background-color: yellow;";
                                             } 
                                             else if($total_score >= 1200){
                                                echo "background-color: green;color:white";
                                             }
                                             else if($total_score >= 800){
                                                echo "background-color: blue;color:white";
                                             }
                                             else
                                             {
                                                echo "background-color: red;color:white";
                                             }
                                           
                                            
                                             ?>"
                                        >
                                        <td>
                                          <?php echo $selExmneRow['exmne_fullname']; ?>
                                        </td>
                                        <td>
                                            <?=$i--?>
                                        </td>
                                        <td>
                                        <?php                                         
                                            echo $en_score;                 
                                         ?>
                                        </td>
                                        <td>
                                        <?php                                         
                                            echo $math_score;                 
                                         ?>
                                        </td>
                                        <td>
                                        <?php                                         
                                            echo $total_score;                 
                                         ?>
                                        </td>
                                        <td>
                                          <?php        
                                            echo $rightEnAnswers." / ".$allEnquestions; ?>
                                        </td>
                                        <td>
                                          <?php        
                                            echo $rightMathAnswers." / ".$allMathquestions; ?>
                                        </td>
                                    </tr>
                                <?php       } // end of examin sessions
                                        } // session check end
                                    }
                                        // end of one examin 
                             ?>                              
                          </tbody>
                        </table>
                    </div>
               


                   <?php
                }
                else
                { ?>
                <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div><b>RANKING BY EXAM</b></div>
                    </div>
                </div>
                </div> 

                 <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Exam List
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableListExam">
                            <thead>
                            <tr>
                                <th class="text-left pl-4">Exam Title</th>
                                <th class="text-left ">Course</th>
                                <th class="text-center" width="8%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $selExam = $conn->query("SELECT * FROM exam_tbl ORDER BY ex_id DESC ");
                                if($selExam->rowCount() > 0)
                                {
                                    while ($selExamRow = $selExam->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td class="pl-4"><?php echo $selExamRow['ex_title']; ?></td>
                                            <td>
                                                <?php 
                                                    $courseId =  $selExamRow['cou_id']; 
                                                    $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$courseId' ");
                                                    while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) {
                                                        echo $selCourseRow['cou_name'];
                                                    }
                                                ?>
                                            </td>
                                            
                                            <td class="text-center">
                                             <a href="?page=ranking-exam&exam_id=<?php echo $selExamRow['ex_id']; ?>"  class="btn btn-success btn-sm">View</a>
                                            </td>
                                        </tr>

                                    <?php }
                                }
                                else
                                { ?>
                                    <tr>
                                      <td colspan="5">
                                        <h3 class="p-3">No Exam Found</h3>
                                      </td>
                                    </tr>
                                <?php }
                               ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
            
                <?php }

             ?>      
            
            
      
        
</div>
         



















<?php 
  date_default_timezone_set("Asia/Baku");
  require "../conn.php";
    session_start();
    if(!isset($_SESSION['examineeSession']['exmne_id']) || empty($_SESSION['examineeSession']['exmne_id']) || !isset($_GET['id']) || empty($_GET['id'])){
      echo "<h1>Error 404. Page not found</h1>";

    }else{
      $exmne_id = $_SESSION['examineeSession']['exmne_id'];

  // $exam_part = 1;
  
  // if(isset($_SESSION['examSession']['session_id']) && empty($_SESSION['examSession']['session_id']) !=false){
  // $exam_part = $_SESSION['examSession']['exam_part'];
  // }else{

  // }

  // functions
  function current_date($time){
    $current_time = new DateTime('NOW');
    $current_time->add(DateInterval::createFromDateString($time.' minute'));
    $current_time = (string) $current_time->format("Y-m-d H:i:s");
    return $current_time;
  }
?> 
<script type="text/javascript" >
   function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};
</script>
 <?php 
     if(!isset($_GET['id']) || empty($_GET['id'])){
        echo "<h1>Error 404. Page not found</h1>";
     }else{
        $examId = $_GET['id'];
        $session_id = null;
        $_SESSION['examineeSession']['session_id']= $session_id;
     }
    $selExamQuery = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$examId' ");
    if($selExamQuery->rowCount()>0){
    $selExam = $selExamQuery->fetch(PDO::FETCH_ASSOC);    
    $question_number = 0;
    $part = 1;
    $_SESSION['examSession']['end_type'] = $selExam['exam_end_type'];
    $_SESSION['examSession']['part'] = $part;
    //  $queryExamAtmp = $conn->query("SELECT * FROM exam_attempt WHERE exam_id='$examId' AND exmne_id = '$exmne_id'");
     $queryExamSession = $conn->query("SELECT * FROM sessions WHERE exam_id='$examId' AND examin_id = '$exmne_id' and exam_end_status=0 ORDER BY session_id DESC LIMIT 1");
    //  $checkExamAtmp = $queryExamAtmp->fetch(PDO::FETCH_ASSOC);
     $checkExamSession = $queryExamSession->fetch(PDO::FETCH_ASSOC);
     if($queryExamSession->rowCount()>0){
      $part = $checkExamSession['current_part'];
      $session_id = $checkExamSession['session_id'];
      $_SESSION['examineeSession']['session_id']= $session_id;
     }  
     
     if($part == 5){
      $sql = $conn->query("UPDATE sessions SET exam_end_status = 1 
      WHERE exam_id = '$examId' AND examin_id = '$exmne_id' AND exam_end_status=0");
      ?>
      <script>window.location.href="../index.php";</script>
    <?php }else{
      $math_time = $selExam['ex_math_time_limit'];
      $math_time_2 = $selExam['ex_math_time_limit_2'];
      $en_time = $selExam['ex_en_time_limit'];
      $en_time_2 = $selExam['ex_en_time_limit_2'];
      $selExamTimeLimit = null;
      
      //  Select Exam time limit
      $queryExamTime = $conn->query("SELECT * FROM sessions WHERE exam_id='$examId' AND examin_id = '$exmne_id' and exam_end_status=0");
      if($queryExamTime->rowCount()>0){
        $selExamTime =  $queryExamTime->fetch(PDO::FETCH_ASSOC);
        if($part == 1){
          $selExamTimeLimit = $selExamTime['en_time'];
            }else if($part == 2){
              if($selExamTime['en_time_2']==null){
                $current_time = current_date($en_time_2);
                $insertExamTime = $conn->query("UPDATE sessions SET en_time_2 = ('$current_time') WHERE exam_id = '$examId'AND examin_id = '$exmne_id' and exam_end_status=0");
              }else{
                $selExamTimeLimit = $selExamTime['en_time_2'];
              }
            }else if($part == 3){
              if($selExamTime['math_time']==null){
                $current_time = current_date($math_time);
                $insertExamTime = $conn->query("UPDATE sessions SET math_time = ('$current_time') WHERE exam_id = '$examId'AND examin_id = '$exmne_id'  and exam_end_status=0");
              }else{
                $selExamTimeLimit = $selExamTime['math_time'];
              }
            } else if($part == 4){
              if($selExamTime['math_time_2']==null){
                $current_time = current_date($math_time_2);
                $insertExamTime = $conn->query("UPDATE sessions SET math_time_2 = ('$current_time') WHERE exam_id = '$examId'AND examin_id = '$exmne_id'  and exam_end_status=0");
              }else{
                $selExamTimeLimit = $selExamTime['math_time_2'];
              }
            }   
       }else{
            
            $current_time = current_date($en_time);
            $insertExamTime = $conn->query("INSERT INTO  sessions(exam_id,examin_id,en_time) VALUES ('$examId','$exmne_id','$current_time')");
            $examAttempt = $conn->query("INSERT INTO exam_attempt(exmne_id,exam_id) VALUES ('$exmne_id','$examId')");
        }
        
        $selPartName = $conn->query("SELECT * FROM sat_exam_parts WHERE exam_part_id = '$part'")->fetch(PDO::FETCH_ASSOC);
        $questinIds = [];

      
 ?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>1To1EDU</title>
    <meta name="description" content="Sat exam module">
    <link rel="stylesheet" href="css/style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="../js/jquery.js"></script>
  </head>
  <body>
    <main>
     
      <header id="" class="fixed-top test-page-header" width="100%">
      <div class="top-header px-4">
        <div class="row">
          <div class="col-4 d-flex justify-content-start align-items-center"><h4><?=$selPartName['exam_part_name']?></h4></div>
          <div class="col-4 d-flex justify-content-center align-items-center">
            <div class="d-inline-block col-sm-12 col-md-12 pt-3 pb-3 w-100">
              <div class="d-flex justify-content-center align-items-center custom-header-r ml-2 mr-2 w-100">
                <span id="global_watch" class="globaltimer"><?=$selExamTimeLimit?></span>
                <i class="fas fa-stopwatch"></i>
              </div>
            </div>
          </div>
          <div class="col-4 d-flex justify-content-end align-items-center">
            <?php 
              // Buttons for math part
              if($part >=3){

               
            ?>
              <div class="btns" >
                <a class="btn" href="https://www.desmos.com/calculator" target="_blank">
                <i class="fas fa-calculator"></i><br> Calculator
              </a>
              <button class="btn" id="reference-btn">
                  <span><i>x<sup>2</sup></i></span><br> Reference
              </button>

                <!-- References -->
                <!-- Modal -->
                <div class="reference-modal" id="reference-modal">
                <div class="reference-actions">
                  <h3>Reference Sheet</h3>
                      <button id="reference-close"><i class="fas fa-times"></i></button>
                  </div>
                  <div class="reference-wrapper nopadding">
                    
                    <div class="content-container">
                        <img src="../assets/images/references/img1.png" alt="">
                        <h3>Special Right Triangles</h3>
                        <img src="../assets/images/references/img1.png" alt="">
                        <p>The number of degrees of arc in a circle is 360.</p>
                        <p>The number of radians of arc in a circle is 2&pi;.</p>
                        <p>The sum of the measures in degrees of the angles of a triangle is 180.</p>
                    </div>
                                
                  </div>
                </div>
                 <!-- End modal -->
              </div>
              <?php 
              // end of Buttons for math part
              } 
            ?>
          </div>
        </div>
      </div>
       <div class="bottom-header">
       <div class="row ">
          <div class="col-12 pt-1 pb-1">
              <div class="page-title text-center">
                  <div class="page-title-subheading" style="color:#fff">
                    <?php echo $selExam['ex_description']; ?>
                  </div>
              </div>
          </div>
          
        </div>
       </div>
      </header>
      <section id="question-section">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <form id="practice_form" name="practice_from" class="" method="post">
                <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $examId; ?>">
                <input type="hidden" name="examAction" id="examAction" >
                <input type="hidden" name="examPart" id="examPart" value="<?=$part?>">
                <input type="hidden" name="examEndPart" id="examEndPart" value="<?=$selExam['exam_end_type']?>">
                
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <div class="panel-body-inner">
                      <?php 
                          $selQuest = $conn->query("SELECT * FROM exam_question_tbl WHERE exam_id='$examId' AND exam_part='$part' ORDER BY eqt_id asc");
                          
                          if($selQuest->rowCount() > 0)
                          {
                              $total_question = $selQuest->rowCount();
                          while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { ?>
                      <?php $questId = $selQuestRow['eqt_id']; 
                            array_push($questinIds,$questId);
                            $selQuestImgs = $conn->query("SELECT * FROM question_images WHERE question_id='$questId' ");
                            $currentAns = "";
                            $selQuestAnsw = $conn->query("SELECT * FROM exam_answers WHERE quest_id='$questId' AND exam_id = '$examId' AND axmne_id = '$exmne_id' AND session_id = '$session_id' ");
                            if($selQuestAnsw->rowCount()>0){
                              $currentAns = $selQuestAnsw->fetch(PDO::FETCH_ASSOC)['exans_answer'];
                            }
                            $ans=['a'=>"",'b'=>"",'c'=>"",'d'=>""];
                            switch($currentAns){
                              case 'a': $ans['a']="selected-answer";break;
                              case 'b': $ans['b']="selected-answer";break;
                              case 'c': $ans['c']="selected-answer";break;
                              case 'd': $ans['d']="selected-answer";break;
                              default: $ans['df'] = $currentAns;
                            }
                      ?>
                      <!-- Question begins -->
                        <div class="row question" data-questionnumber="<?=$question_number?>" data-questionid="<?=$question_number?>" data-questiontype="<?=$selQuestRow['question_type']?>">
                        
                          <div class="col-md-12 mt-5">


                          </div>

                          <div class="col-md-6 question2wrapper">

                            <div class="question2">
                              <?=$selQuestRow['question_detail']; ?>  
                              <?php 
                                if($selQuestImgs->rowCount() > 0)
                              { 
                                while ($questImg = $selQuestImgs->fetch(PDO::FETCH_ASSOC)) { 
                                ?>
                              <p><img alt="" src="../assets/images/question-images/<?=$questImg['img_name']?>" class="img-responsive"></p>
                              <?php } }?>
                              </div>
                          </div>
                          <br class="visible-xs">
                          <div class="col-md-6 questioncontainer">
                            <div class="actualquestion"><p><?=$selQuestRow['exam_question']?></p><p></p>
                            </div>
                            <?php
                                if($selQuestRow['question_type']==0){
                                 
                            ?>
                            <div class="option-items" onclick="">
                                <div class="question_answer <?=$ans['a']?>" onclick="" data-question-id="<?=$questId?>" data-answer-value="a">
                                <div class="abcde text-capitalize">a</div>
                                <div class="question-option"><p></p><p><?=$selQuestRow['exam_ch1']?></p>
                                </div>
                              </div>
                                <div class="question_answer <?=$ans['b']?>" onclick="" data-question-id="<?=$questId?>" data-answer-value="b">
                                <div class="abcde text-capitalize">b</div>
                                <div class="question-option"><p></p><p><?=$selQuestRow['exam_ch2']?></p>
                              </div>
                              </div>
                                <div class="question_answer <?=$ans['c']?>" onclick="" data-question-id="<?=$questId?>" data-answer-value="c">
                                <div class="abcde text-capitalize">c</div>
                                <div class="question-option"><p></p><p><?=$selQuestRow['exam_ch3']?></p>
                                </div>
                              </div>
                              <div class="question_answer <?=$ans['d']?>" onclick="" data-question-id="<?=$questId?>" data-answer-value="d">
                                <div class="abcde text-capitalize">d</div>
                                <div class="question-option"><p></p><p><?=$selQuestRow['exam_ch4']?></p>
                                </div>
                              </div>
                              <ol type="A" style="display: none" >
                                  <li><input type="radio" name="question[<?=$questId?>]" value="a"></li>
                                  <li><input type="radio" name="question[<?=$questId?>]" value="b"></li>
                                  <li><input type="radio" name="question[<?=$questId?>]" value="c"></li>
                                  <li><input type="radio" name="question[<?=$questId?>]" value="d"></li>
                              </ol>
                            </div>

                            <?php }else{ ?>
                              <div class="open-question-asnwer my-4">
                                <label>Answer: </label>
                                  <input type="text" oninput="saveAnswer(<?=$questId?>,<?=$examId?>,<?=$selQuestRow['question_type']?>)" name="question[<?=$questId?>]" value="<?=$ans['df']?>" >
                              </div>

                         <?php   } ?>
                              </div>
                        </div>
                        <?php $question_number++;} ?>
                      <!-- Question ends -->
                      </div>
                    </div>
                  </div>
              </form>
            </div>
          </div>
    </section>
    <!--   Bottom bar -->
    <div class="container-fluid">

      <div class="navbar-fixed-bottom normal-row">

        <div class="panel-footer bottombar">

          <!-- Pagination modal -->
            <div class="pagination-modal" id="question-modal">
              <!-- <div class="previousButton">Previous</div> -->
              <!-- <div class="nextButton">Next</div> -->
              <div class="pagination-wrapper nopadding">
                <ul class="pagination">
                    <!-- <li class="bottombar-questions bottombar-highlight" data-questionid="1" data-questionnumber="1" onclick="showOnlyQuestion(1)">1</li> -->
                      
                    <?php if($total_question>0){
                     
                      $j=0;
                      while($j<$total_question){
                      ?>
                      <li class="bottombar-questions" data-question="<?=$questinIds[$j]?>" data-questionid="<?=$j?>" data-questionnumber="<?=$j?>" onclick="showOnlyQuestion(<?=$j?>)"><?=$j+1?></li>

                    <?php $j++; } }?>
                </ul>              
              </div>
            </div>
              <!-- end of pagination modal -->
           <div class="row">
            <div class="col-sm-4">
                    <h3><?=$_SESSION['examineeSession']['exmne_fullname']?></h3>  
            </div>
           <div class="col-sm-4">
                <button class="btn " id="questions-btn">Questions <span id="current-question">1</span> of <?=$total_question?> &nbsp; <i class="fas fa-chevron-up"></i></button>
            </div>
            <div class="col-sm-4">
              <button class="btn  btn-primary btn-back mr-1 previousButton">
                      Back
              </button>
              <button class="btn  btn-primary btn-next nextButton">
                      Next
              </button>
            </div>
           </div>
                      

        </div>

      </div>

    </div>
    <?php } ?>
  </div>
<!-- /container -->

    </main>
    <script> var totalQuestions = <?=$total_question?>; var exam_id = <?=$examId?>; var part = <?=$part?>;</script>
    <script src="js/custom.js"></script>
    <script src="https://kit.fontawesome.com/b32d5a037c.js" crossorigin="anonymous"></script>
    <script src="../js/jquery.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js" ></script>
    <script src="js/sweetalert.js"></script>
  </body>

</html>
<?php   
} }else{
  echo "<h1>Exam not found</h1>";
}} ?>
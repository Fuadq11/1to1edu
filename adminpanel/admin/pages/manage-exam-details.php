
<?php 
   $exId = $_GET['id'];

   $selExam = $conn->query("SELECT * FROM exam_tbl ex join exam_types e on e.type_id=ex.exam_type join exam_end_types et on et.end_type_id = ex.exam_end_type WHERE ex_id='$exId' ");
   $selExamRow = $selExam->fetch(PDO::FETCH_ASSOC);

   $courseId = $selExamRow['cou_id'];
   $selCourse = $conn->query("SELECT cou_name as courseName FROM course_tbl WHERE cou_id='$courseId' ")->fetch(PDO::FETCH_ASSOC);
 ?>


<div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                     <div class="page-title-heading">
                        <div> MANAGE EXAM
                            <div class="page-title-subheading">
                              Add Question for <?php echo $selExamRow['ex_title']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
            
            <div class="col-md-12">
            <div id="refreshData">
            <div class="row">
                  <div class="col-md-4">
                      <div class="main-card mb-3 card">
                          <div class="card-header">
                            <i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Exam Information
                          </div>
                          <div class="card-body">
                           <form method="post" id="updateExamFrm">
                               <div class="form-group">
                                <label>Course</label>
                                <select class="form-control" name="courseId" required="">
                                  <option value="<?php echo $selExamRow['cou_id']; ?>"><?php echo $selCourse['courseName']; ?></option>
                                  <?php 
                                    $selAllCourse = $conn->query("SELECT * FROM course_tbl ORDER BY cou_id DESC");
                                    while ($selAllCourseRow = $selAllCourse->fetch(PDO::FETCH_ASSOC)) { ?>
                                      <option value="<?php echo $selAllCourseRow['cou_id']; ?>"><?php echo $selAllCourseRow['cou_name']; ?></option>
                                    <?php }
                                   ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Select Exam type</label>
                                <select class="form-control" name="exam_type" id="">
                                  <option value="<?=$selExamRow['exam_type']?>"><?=$selExamRow['name']?></option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Select Exam end type</label>
                                <select class="form-control" name="exam_end_type" id="">
                                  <option value="<?=$selExamRow['exam_end_type']?>"><?=$selExamRow['end_type_name']?></option>
                                  <?php 
                                    $selEndTypes = $conn->query("SELECT * FROM exam_end_types");
                                    while ($selEndType = $selEndTypes->fetch(PDO::FETCH_ASSOC)) { ?>
                                      <option value="<?=$selEndType['end_type_id']?>"><?=$selEndType['end_type_name']?></option>
                                    <?php }
                                   ?>
                                
                                </select>
                              </div>  
                              <div class="form-group">
                                <label>Exam Title</label>
                                <input type="hidden" name="examId" value="<?php echo $selExamRow['ex_id']; ?>">
                                <input type="" name="examTitle" class="form-control" required="" value="<?php echo $selExamRow['ex_title']; ?>">
                              </div>  

                              <div class="form-group">
                                <label>Exam Description</label>
                                <input type="" name="examDesc" class="form-control" required="" value="<?php echo $selExamRow['ex_description']; ?>">
                              </div>  

                              <div class="form-group">
                                <label>Section 1, Module 1 time limit: English</label>
                                <div class="row align-items-center ml-1"><input type="number"  class="form-control w-25 mr-1" name="en_timeLimit" required=""
                                      value="<?php echo $selExamRow['ex_en_time_limit']; ?>"
                                ><span style="font-size: 18px;"> Minutes</span></div>             
                              </div>
                              <div class="form-group">
                                <label>Section 1, Module 2 time limit: English</label>
                                <div class="row align-items-center ml-1"><input type="number" class="form-control w-25 mr-1" name="en_timeLimit_2" required=""
                                      value="<?php echo $selExamRow['ex_en_time_limit_2']; ?>"
                                > <span style="font-size: 18px;"> Minutes</span></div>            
                              </div>
                              <div class="form-group">
                                <label>Section 2, Module 1 time limit: Math</label>
                                <div class="row align-items-center ml-1"><input type="number" class="form-control w-25 mr-1" name="math_timeLimit" required=""
                                    value="<?php echo $selExamRow['ex_math_time_limit']; ?>"
                                ><span style="font-size: 18px;"> Minutes</span></div>
                              </div>
                              <div class="form-group">
                                <label>Section 2, Module 2 time limit: Math</label>
                                <div class="row align-items-center ml-1"><input type="number" class="form-control w-25 mr-1" name="math_timeLimit_2" required=""
                                    value="<?php echo $selExamRow['ex_math_time_limit_2']; ?>"
                                ><span style="font-size: 18px;"> Minutes</span></div>
                              </div>

                              <div class="form-group" align="right">
                                <button type="submit" class="btn btn-primary btn-lg">Update</button>
                              </div> 
                           </form>                           
                          </div>
                      </div>
                   
                  </div>
                  <div class="col-md-8">
                    <?php 
                        $selQuest = $conn->query("SELECT * FROM exam_question_tbl WHERE exam_id='$exId' ORDER BY eqt_id asc");
                    ?>
                     <div class="main-card mb-3 card">
                          <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Exam Question's 
                            <span class="badge badge-pill badge-primary ml-2">
                              <?php echo $selQuest->rowCount(); ?>
                            </span>
                             <div class="btn-actions-pane-right">
                                <button class="btn btn-sm btn-primary " data-toggle="modal" data-target="#modalForAddQuestion">Add Question</button>
                              </div>
                          </div>
                          <div class="card-body" >
                            <div class="scroll-area-sm" style="min-height: 400px;">
                               <div class="scrollbar-container">

                            <?php 
                               
                               if($selQuest->rowCount() > 0)
                               {  ?>
                                 <div class="table-responsive">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                                        <thead>
                                        <tr>
                                            <th class="text-left pl-1">Question</th>
                                            <th class="text-center" width="20%">Variants</th>
                                            
                                            <th class="text-center" width="20%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <?php 
                                            
                                            
                                            if($selQuest->rowCount() > 0)
                                            {
                                               $i = 1;
                                               while ($selQuestionRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { ?>

                                               
                                                <tr>
                                                        <td >
                                                            <b><?php echo $i++ ; ?> .) <?php echo $selQuestionRow['exam_question']; ?></b><br>

                                                            <?php 
                                                            $question_id = $selQuestionRow["eqt_id"];
                                                            $selQuestImg = $conn->query("SELECT * FROM question_images WHERE question_id='$question_id' ORDER BY img_id asc");
                                                            while ($selQuestionimg = $selQuestImg->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                                <img width="100" src="../..//assets/images/question-images/<?=$selQuestionimg["img_name"]?>">
                                                            <?php
                                                            } ?> 
                                                        </td> <td>
                                                            <?php
                                                              if($selQuestionRow['question_type']==0){

                                                              // Choice A
                                                              if($selQuestionRow['exam_ch1'] == $selQuestionRow['exam_answer'])
                                                              { ?>
                                                                
                                                                <span class="pl-4 text-success">A - <?php echo  $selQuestionRow['exam_ch1']; ?></span><br>
                                                              <?php }
                                                              else
                                                              { ?>
                                                                <span class="pl-4">A - <?php echo $selQuestionRow['exam_ch1']; ?></span><br>
                                                              <?php }

                                                              // Choice B
                                                              if($selQuestionRow['exam_ch2'] == $selQuestionRow['exam_answer'])
                                                              { ?>
                                                                <span class="pl-4 text-success">B - <?php echo $selQuestionRow['exam_ch2']; ?></span><br>
                                                              <?php }
                                                              else
                                                              { ?>
                                                                <span class="pl-4">B - <?php echo $selQuestionRow['exam_ch2']; ?></span><br>
                                                              <?php }

                                                              // Choice C
                                                              if($selQuestionRow['exam_ch3'] == $selQuestionRow['exam_answer'])
                                                              { ?>
                                                                <span class="pl-4 text-success">C - <?php echo $selQuestionRow['exam_ch3']; ?></span><br>
                                                              <?php }
                                                              else
                                                              { ?>
                                                                <span class="pl-4">C - <?php echo $selQuestionRow['exam_ch3']; ?></span><br>
                                                              <?php }

                                                              // Choice D
                                                              if($selQuestionRow['exam_ch4'] == $selQuestionRow['exam_answer'])
                                                              { ?>
                                                                <span class="pl-4 text-success">D - <?php echo $selQuestionRow['exam_ch4']; ?></span><br>
                                                              <?php }
                                                              else
                                                              { ?>
                                                                <span class="pl-4">D - <?php echo $selQuestionRow['exam_ch4']; ?></span><br> </td>
                                                                
                                                              <?php } }else{ ?>
                                                                </td>
                                                                
                                                             <?php }

                                                             ?>
                                                            
                                                        
                                                        <td class="text-center">
                                                         <a rel="facebox" id="updateQuestion" href="facebox_modal/updateQuestion.php?id=<?php echo $selQuestionRow['eqt_id']; ?>" class="btn btn-sm btn-primary">Update</a>
                                                         <button type="button" id="deleteQuestion" data-id='<?php echo $selQuestionRow['eqt_id']; ?>'  class="btn btn-danger btn-sm">Delete</button>
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
                               <?php }
                               else
                               { ?>
                                  <h4 class="text-primary">No question found...</h4>
                                 <?php
                               }
                             ?>
                               </div>
                            </div>


                          </div>
                        
                      </div>
                  </div>
              </div>  
            </div> 
            </div>
               
            </div>
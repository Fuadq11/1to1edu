<!-- Modal For Add Course -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/ckeditor.js" integrity="sha512-F8fV4+wpHYl9zul08Soff9H9fCx6OMIFfgbQcy+2v2gV7PdbT0OgM1LFwujQmwlLGWWKNbOFZ13uWP+Cbe0Ngw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<div class="modal fade" id="modalForAddCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <form class="refreshFrm" id="addCourseFrm" method="post">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Course</label>
            <input type="" name="course_name" id="course_name" class="form-control" placeholder="Input Course" required="" autocomplete="off">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Now</button>
      </div>
    </div>
   </form>
  </div>
</div>


<!-- Modal For Update Course -->
<div class="modal fade myModal" id="updateCourse-<?php echo $selCourseRow['cou_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
     <form class="refreshFrm" id="addCourseFrm" method="post" >
       <div class="modal-content myModal-content" >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update ( <?php echo $selCourseRow['cou_name']; ?> )</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Course</label>
              <input type="" name="course_name" id="course_name" class="form-control" value="<?php echo $selCourseRow['cou_name']; ?>">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Now</button>
        </div>
      </div>
     </form>
    </div>
  </div>


<!-- Modal For Add Exam -->
<div class="modal fade" id="modalForExam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <form class="refreshFrm" id="addExamFrm" method="post">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Exam</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Select Course</label>
            <select class="form-control" name="courseSelected">
              <option value="0">Select Course</option>
              <?php 
                $selCourse = $conn->query("SELECT * FROM course_tbl ORDER BY cou_id DESC");
                if($selCourse->rowCount() > 0)
                {
                  while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) { ?>
                     <option value="<?php echo $selCourseRow['cou_id']; ?>"><?php echo $selCourseRow['cou_name']; ?></option>
                  <?php }
                }
                else
                { ?>
                  <option value="0">No Course Found</option>
                <?php }
               ?>
            </select>
          </div>

          <div class="form-group">
            <label>Exam Time Limit</label>
            <select class="form-control" name="timeLimit" required="">
              <option value="0">Select time</option>
              <option value="10">10 Minutes</option> 
              <option value="20">20 Minutes</option> 
              <option value="30">30 Minutes</option> 
              <option value="40">40 Minutes</option> 
              <option value="50">50 Minutes</option> 
              <option value="60">60 Minutes</option> 
            </select>
          </div>

          <div class="form-group">
            <label>Question Limit to Display</label>
            <input type="number" name="examQuestDipLimit" id="" class="form-control" placeholder="Input question limit to display">
          </div>

          <div class="form-group">
            <label>Exam Title</label>
            <input type="" name="examTitle" class="form-control" placeholder="Input Exam Title" required="">
          </div>

          <div class="form-group">
            <label>Exam Description</label>
            <textarea name="examDesc" class="form-control" rows="4" placeholder="Input Exam Description" required=""></textarea>
          </div>


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Now</button>
      </div>
    </div>
   </form>
  </div>
</div>


<!-- Modal For Add Examinee -->
<div class="modal fade" id="modalForAddExaminee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <form class="refreshFrm" id="addExamineeFrm" method="post">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Examinee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Fullname</label>
            <input type="" name="fullname" id="fullname" class="form-control" placeholder="Input Fullname" autocomplete="off" required="">
          </div>
          <div class="form-group">
            <label>Birhdate</label>
            <input type="date" name="bdate" id="bdate" class="form-control" placeholder="Input Birhdate" autocomplete="off" >
          </div>
          <div class="form-group">
            <label>Gender</label>
            <select class="form-control" name="gender" id="gender">
              <option value="0">Select gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label>Course</label>
            <select class="form-control" name="course" id="course">
              <option value="0">Select course</option>
              <?php 
                $selCourse = $conn->query("SELECT * FROM course_tbl ORDER BY cou_id DESC");
                if($selCourse->rowCount() > 0)
                {
                  while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) { ?>
                     <option value="<?php echo $selCourseRow['cou_id']; ?>"><?php echo $selCourseRow['cou_name']; ?></option>
                  <?php }
                }
                else
                { ?>
                  <option value="0">No Course Found</option>
                <?php }
               ?>
            </select>
          </div>
          <div class="form-group">
            <label>Year Level</label>
            <select class="form-control" name="year_level" id="year_level">
              <option value="0">Select year level</option>
              <option value="first year">First Year</option>
              <option value="second year">Second Year</option>
              <option value="third year">Third Year</option>
              <option value="fourth year">Fourth Year</option>
            </select>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Input Email" autocomplete="off" required="">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Input Password" autocomplete="off" required="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Now</button>
      </div>
    </div>
   </form>
  </div>
</div>



<!-- Modal For Add Question -->
<div class="modal fade" id="modalForAddQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Question for <br><?php echo $selExamRow['ex_title']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="refreshFrm" method="post" id="addQuestionFrm" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="col-md-12">
        <div class="form-group">
						<label><b>Question detail:</b> </label>
						<textarea type="" name="question_detail" id="question-detail" class="form-control"  autocomplete="off" required></textarea>
					</div>
          <div class="form-group">
            <label><b>Question</b></label>
            <input type="hidden" name="examId" value="<?php echo $exId; ?>">
            <textarea name="question" id="" class="form-control" required></textarea>
            <!-- <input type="" name="question" id="course_name" class="form-control" placeholder="Input question" autocomplete="off"> -->
          </div>
          <div class="form-group">
            <label><b>Images: </b></label> <button type="button" class="btn btn-primary" id="addImgBtn" >Add new +</button> <br>
            <div id="questionImgs">
              
            </div>
              
           </div>
          <fieldset>
          
          <div class="form-group">
                <label><b>Question for: </b></label>
                <select name="question_for" id="" class="form-control">
                  <?php
                    $selParts = $conn->query("SELECT * FROM sat_exam_parts");
                    if($selParts->rowCount()>0){ 
                      while($selPart = $selParts->fetch(PDO::FETCH_ASSOC)){ ?>
                      <option value="<?=$selPart['exam_part_id']?>"><?=$selPart['exam_part_name']?></option>
                    <?php }}else{?>
                      <option value="0">Parts not found</option>
                  <?php  } ?>
                  
                </select>
              
            </div>
            <div class="form-group">
                <label><b>Question type: </b></label>
                  
                <label for="type0"><input type="radio" name="question_type" id="type0" value="0" onclick="questionChange(0)" checked> Multiple choice</label>
                <label for="type1"><input type="radio" name="question_type" id="type1" value="1" onclick="questionChange(1)"> Open question</label>

            </div>
            <div class="divider "></div>
            <div id="question-data">
                <div class="form-group">
                  <label><b>Choice A</b></label>
                  <!-- <input type="" name="choice_A" id="choice_A" class="form-control" placeholder="Input choice A" autocomplete="off" required> -->
                  <textarea name="choice_A" id="" class="form-control" height="100" required></textarea>
                </div>

                <div class="form-group">
                  <label><b>Choice B</b></label>
                  <!-- <input type="" name="choice_B" id="choice_B" class="form-control" placeholder="Input choice B" autocomplete="off" required> -->
                  <textarea name="choice_B" id="" class="form-control" required></textarea>                  
                </div>

                <div class="form-group">
                  <label><b>Choice C</b></label>
                  <!-- <input type="" name="choice_C" id="choice_C" class="form-control" placeholder="Input choice C" autocomplete="off" required> -->
                  <textarea name="choice_C" id="" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                  <label><b>Choice D</b></label>
                  <!-- <input type="" name="choice_D" id="choice_D" class="form-control" placeholder="Input choice D" autocomplete="off" required> -->
                  <textarea name="choice_D" id="" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                  <label><b>Correct Answer:</b></label>
                  <select name="correctAnswer" id="" class="form-control" required>
                      <option value="a">A</option>
                      <option value="b">B</option>
                      <option value="c">C</option>
                      <option value="d">D</option>
                  </select>
                <!-- <input type="" name="correctAnswer" id="" class="form-control" placeholder="Input correct answer" autocomplete="off" required> -->
              </div>
            </div>
            
          </fieldset>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Now</button>
      </div>
      </form>
    </div>
   
  </div>
</div>
<script>
  $(document).ready(function(){
    CKEDITOR.replace('question_detail');
    CKEDITOR.replace('question');
    CKEDITOR.replace('choice_A');
    CKEDITOR.replace('choice_B');
    CKEDITOR.replace('choice_C');
    CKEDITOR.replace('choice_D');
  })
 
</script>
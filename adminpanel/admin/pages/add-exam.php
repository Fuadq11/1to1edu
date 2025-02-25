<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>ADD EXAM</div>
                </div>
            </div>
        </div>        
        
        <div class="col-12">
        <form class="refreshFrm" id="addExamFrm" method="post">
     <div class="modal-content">
      <div class="modal-body">
        <div class="col-md-12 row">
          <div class="form-group col-2">
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
          
          <div class="form-group col-2">
            <label>Select Exam type</label>
            <select class="form-control" name="exam_type" id="">
            <?php
              $selTypes = $conn->query("SELECT * FROM exam_types");
              if($selTypes->rowCount()>0){ 
                while($selType = $selTypes->fetch(PDO::FETCH_ASSOC)){
                ?>
                <option value="<?=$selType['type_id']?>"><?=$selType['name']?></option>
              <?php }}else{   ?>
                <option value="0">Types not found</option>
              <?php   }  ?>
              
            </select>
          </div>
          <div class="form-group col-2">
            <label>Select Exam end type</label>
            <select class="form-control" name="exam_end_type" id="">
            <?php 
              $selEndTypes = $conn->query("SELECT * FROM exam_end_types");
              while ($selEndType = $selEndTypes->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?=$selEndType['end_type_id']?>"><?=$selEndType['end_type_name']?></option>
              <?php }
              ?>
            </select>
          </div>

          <!-- <div class="form-group col-4">
            <label>Question Limit to Display</label>
            <input type="number" name="examQuestDipLimit" id="" class="form-control" placeholder="Input question limit to display">
          </div> -->

          <div class="form-group col-3">
            <label>Exam Title</label>
            <input type="" name="examTitle" class="form-control" placeholder="Input Exam Title" required="">
          </div>

          <div class="form-group col-3">
            <label>Exam Description</label>
            <textarea name="examDesc" class="form-control" rows="4" placeholder="Input Exam Description" required=""></textarea>
          </div>
        </div>
          <div class="row col-12 pl-3">
           
            <div class="form-group col-2">
              <label>Section 1, Module 1 time limit: English</label>
              <div class="row align-items-center"><input type="number" class="form-control w-50 mr-1" name="en_timeLimit" required=""><span style="font-size: 18px;"> Minutes</span></div>             
            </div>
            <div class="form-group col-2">
              <label>Section 1, Module 2 time limit: English</label>
              <div class="row align-items-center"><input type="number" class="form-control w-50 mr-1" name="en_timeLimit_2" required=""> <span style="font-size: 18px;"> Minutes</span></div>            
            </div>
            <div class="form-group col-2">
              <label>Section 2, Module 1 time limit: Math</label>
              <div class="row align-items-center"><input type="number" class="form-control w-50 mr-1" name="math_timeLimit" required=""><span style="font-size: 18px;"> Minutes</span></div>
            </div>
            <div class="form-group col-2">
              <label>Section 2, Module 2 time limit: Math</label>
              <div class="row align-items-center"><input type="number" class="form-control w-50 mr-1" name="math_timeLimit_2" required=""><span style="font-size: 18px;"> Minutes</span></div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add Now</button>
      </div>
    </div>
   </form>
        </div>
    
    
    </div>
</div>
         


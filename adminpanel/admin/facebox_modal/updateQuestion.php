
<?php 
  include("../../../conn.php");
  $id = $_GET['id'];
 
  $selCourse = $conn->query("SELECT * FROM exam_question_tbl WHERE eqt_id='$id' ")->fetch(PDO::FETCH_ASSOC);
  $question_images =  $conn->query("SELECT * FROM question_images WHERE question_id='$id' ");
 ?>
<script src="plugins/ckeditor/ckeditor.js"></script>
<fieldset style="width:543px;" >
	<legend><i class="facebox-header"><i class="edit large icon"></i>&nbsp;Update Question</i></legend>
  
  <div class="col-md-12 mt-4">
    <form method="post" id="updateQuestionFrm" enctype="multipart/form-data">
      <div class="form-group">
						<label><b>Question detail:</b> </label>
						<textarea name="up_question_detail"  class="form-control"  required><?= $selCourse['question_detail']?></textarea>
      </div>
      <div class="form-group">
        <legend>Question</legend>
        <input type="hidden" name="question_id" value="<?php echo $id; ?>">
        <textarea name="up_question" class="form-control" required><?php echo $selCourse['exam_question']; ?></textarea>
      </div>
      <div class="form-group">
            <label><b>Images: </b></label> <button type="button" class="btn btn-primary" id="up-addImgBtn" >Add new +</button> <br>
            <div id="up-questionImgs">
              <?php 
                if($question_images->rowCount()>0){
                 while ($img=$question_images->fetch(PDO::FETCH_ASSOC)){
                      ?>
                  <div class="multiple-imgs"><input type="image" width="100" accept="Image/*" src="<?="../../assets/images/question-images/".$img['img_name']?>"> <button type="button" class="deleteImgBtn btn btn-danger" onclick="question_update_dlt_img(this,<?=$img['img_id']?>,'<?=$img['img_name']?>')" >Delete</button> </div>

                  <?php }}
              ?>
            </div>
              
           </div>

          <fieldset>
          
          <div class="form-group">
                <label><b>Question for: </b></label>
                <select name="up_question_for" id="" class="form-control">
                
                  <?php
                    $selParts = $conn->query("SELECT * FROM sat_exam_parts");
                    if($selParts->rowCount()>0){ 
                      while($selPart = $selParts->fetch(PDO::FETCH_ASSOC)){ 
                        if($selPart['exam_part_id'] == $selCourse['exam_part']){?>
                      <option value="<?=$selPart['exam_part_id']?>" selected><?=$selPart['exam_part_name']?></option>

                      <?php  }else{
                     
                        ?>
                      <option value="<?=$selPart['exam_part_id']?>"><?=$selPart['exam_part_name']?></option>
                    <?php }}}else{?>
                      <option value="0">Parts not found</option>
                  <?php  } ?>
                </select>
              
            </div>
            <div class="form-group">
                <label><b>Question type: </b></label>
                <?php
                    if($selCourse['question_type']==0){
                    ?>          
                      <label for="up_type0"><input type="radio" name="up_question_type" id="up_type0" value="0" onclick="up_questionChange(0)" checked> Multiple choice</label>
                      <label for="up_type1"><input type="radio" name="up_question_type" id="up_type1" value="1" onclick="up_questionChange(1)"> Open question</label>
                  <?php }else{
                    ?>          
                    <label for="up_type0"><input type="radio" name="up_question_type" id="up_type0" value="0" onclick="up_questionChange(0)" > Multiple choice</label>
                    <label for="up_type1"><input type="radio" name="up_question_type" id="up_type1" value="1" onclick="up_questionChange(1)" checked> Open question</label>
                    <?php
                  }
                ?>
                

            </div>
            <div class="divider "></div>
            <div id="up_question-data">
              <?php if($selCourse['question_type']==0){
                ?>
                  <div class="form-group">
                  <label><b>Choice A</b></label>
                  <!-- <input type="" name="choice_A" id="choice_A" class="form-control" placeholder="Input choice A" autocomplete="off" required> -->
                  <textarea name="up_choice_A" id="" class="form-control" height="100" required><?=$selCourse['exam_ch1']?></textarea>
                </div>

                <div class="form-group">
                  <label><b>Choice B</b></label>
                  <!-- <input type="" name="choice_B" id="choice_B" class="form-control" placeholder="Input choice B" autocomplete="off" required> -->
                  <textarea name="up_choice_B" id="" class="form-control" required><?=$selCourse['exam_ch2']?></textarea>                  
                </div>

                <div class="form-group">
                  <label><b>Choice C</b></label>
                  <!-- <input type="" name="choice_C" id="choice_C" class="form-control" placeholder="Input choice C" autocomplete="off" required> -->
                  <textarea name="up_choice_C" id="" class="form-control" required><?=$selCourse['exam_ch3']?></textarea>
                </div>

                <div class="form-group">
                  <label><b>Choice D</b></label>
                  <!-- <input type="" name="choice_D" id="choice_D" class="form-control" placeholder="Input choice D" autocomplete="off" required> -->
                  <textarea name="up_choice_D" id="" class="form-control" required><?=$selCourse['exam_ch4']?></textarea>
                </div>
                <div class="form-group">
                <label><b>Correct Answer</b></label>
                  <select name="up_correctAnswer" id="" class="form-control" required>
                    <?php
                      if(strtolower($selCourse['exam_answer'])=='a'){ ?>
                        <option value="a" selected>A</option>
                     <?php }else{ ?>
                        echo '<option value="a">A</option>
                        <?php }
                      if(strtolower($selCourse['exam_answer'])=='b'){ ?>
                        <option value="b" selected>B</option>
                        <?php }else{ ?>
                        <option value="b">B</option>
                        <?php }
                      if(strtolower($selCourse['exam_answer'])=='c'){ ?>
                        <option value="c" selected>C</option>
                        <?php }else{ ?>
                      <option value="c">C</option>
                        <?php }
                      if(strtolower($selCourse['exam_answer'])=='d'){ ?>
                        <option value="d" selected>D</option>
                        <?php }else{ ?>
                        <option value="d">D</option>
                        <?php  } 
                    ?>
                  </select>
               
              </div>
             <?php }else{ ?>
              <div class="form-group">
                <label><b>Correct Answer: </b></label>
                <input type="" name="up_correctAnswer" id="" class="form-control" placeholder="Input correct answer" autocomplete="off" required value="<?=$selCourse['exam_answer']?>">
              </div>
            <?php }
             
             ?>
            
            </div>
            
          </fieldset>
      <div class="form-group" align="right">
        <button type="submit" class="btn btn-sm btn-primary">Update Now</button>
      </div>

      
    </form>
  </div>
</fieldset>
<script>
  $( document ).ready(function(){
    CKEDITOR.replace('up_question_detail');
  CKEDITOR.replace('up_question');
  CKEDITOR.replace('up_choice_A');
  CKEDITOR.replace('up_choice_B');
  CKEDITOR.replace('up_choice_C');
  CKEDITOR.replace('up_choice_D');
  })
  
  // update question form image add
  let up_img_id=1;
		document.querySelector("#up-addImgBtn").addEventListener("click",function(){
			let newImgElement = `<div class="multiple-imgs" data-img-id="${up_img_id}"><input type="file" name="up_questionImage[]" accept="Image/*"> <button type="button" class="deleteImgBtn btn btn-danger" data-img-id="${up_img_id}" onclick="deleteImgElement(this)">Delete</button> </div>`;
			$("#up-questionImgs").append(newImgElement);
			up_img_id++;

		})
</script>




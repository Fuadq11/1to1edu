<div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>MANAGE EXAM</div>
                    </div>
                </div>
            </div>        
            
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">ExAM List
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                            <thead>
                            <tr>
                                <th class="text-left pl-4">Exam Title</th>
                                <th class="text-left ">Course</th>
                                <th class="text-left ">Description</th>
                                <th class="text-left ">Math 1 Time limit</th>  
                                <th class="text-left ">Math 2 Time limit</th>  
                                <th class="text-left ">En 1 Time limit</th>  
                                <th class="text-left ">En 2 Time limit</th>  
                                <th class="text-left ">Status</th>  
                                <th class="text-center" width="20%">Action</th>
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
                                            <td><?php echo $selExamRow['ex_description']; ?></td>
                                            <td><?php echo $selExamRow['ex_math_time_limit']; ?></td>
                                            <td><?php echo $selExamRow['ex_math_time_limit_2']; ?></td>
                                            <td><?php echo $selExamRow['ex_en_time_limit']; ?></td>
                                            <td><?php echo $selExamRow['ex_en_time_limit_2']; ?></td>
                                            <td>
                                            <?php if($selExamRow['status']==0) {?>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input exam_status_changer" id="exam_status_<?=$selExamRow['ex_id']?>" data-id='<?=$selExamRow['ex_id']?>'>
                                                    <label class="custom-control-label" for="exam_status_<?=$selExamRow['ex_id']?>">Inactive</label>
                                                </div>
                                                <?php }else{ ?>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input exam_status_changer" id="exam_status_<?=$selExamRow['ex_id']?>" checked data-id='<?=$selExamRow['ex_id']?>'>
                                                        <label class="custom-control-label" for="exam_status_<?=$selExamRow['ex_id']?>">Active</label>
                                                    </div>  
                                                <?php } ?>
                                            </td>
                                            <td class="text-center">
                                             <a href="?page=manage-exam-details&id=<?php echo $selExamRow['ex_id']; ?>" type="button" class="btn btn-primary btn-sm">Manage</a>
                                             <button type="button" id="deleteExam" data-id='<?php echo $selExamRow['ex_id']; ?>'  class="btn btn-danger btn-sm">Delete</button>
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
      
        
</div>
         

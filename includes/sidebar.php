<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">

         
            <li class="app-sidebar__heading">
                <a href="home.php">
                     
                     Dashboard
                   
                </a>
            </li>
                <!-- <li class="app-sidebar__heading">AVAILABLE EXAM'S</li>
                <li>
                <a href="#">
                     <i class="metismenu-icon pe-7s-display2"></i>
                     All Exam's
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul >
                    <?php 
                        
                        // if($selExam->rowCount() > 0)
                        // {
                        //     while ($selExamRow = $selExam->fetch(PDO::FETCH_ASSOC)) { ?>
                                 <li>
                                 <a href="#" id="startQuiz" data-id="<?php echo $selExamRow['ex_id']; ?>"  >
                                    <?php 
                                        // $lenthOfTxt = strlen($selExamRow['ex_title']);
                                        // if($lenthOfTxt >= 23)
                                        // { ?>
                                          <?php //echo substr($selExamRow['ex_title'], 0, 20);?>.....
                                         <?php //}
                                        // else
                                        // {
                                        //     echo $selExamRow['ex_title'];
                                        // }
                                     ?>
                                 </a>
                                 </li>
                            <?php //}
                        //}
                        //else
                       // { ?>
                            <a href="#">
                                <i class="metismenu-icon"></i>No Exam's @ the moment
                            </a>
                        <?php //}
                     ?>


                </ul>
                </li> -->

                 <li class="app-sidebar__heading">TAKEN EXAM'S</li>
                <li>
                  <?php 
                    $selTakenExam = $conn->query("SELECT * FROM exam_tbl et INNER JOIN sessions ea ON et.ex_id = ea.exam_id WHERE examin_id='$exmneId' AND ea.exam_end_status = 1 ORDER BY ea.session_id DESC  ");

                    if($selTakenExam->rowCount() > 0)
                    {
                        $i=$selTakenExam->rowCount();
                        while ($selTakenExamRow = $selTakenExam->fetch(PDO::FETCH_ASSOC)) { ?>
                            <a href="home.php?page=result&id=<?=$selTakenExamRow['ex_id']?>&s_id=<?=$selTakenExamRow['session_id']?>" >
                               
                                <?php echo $selTakenExamRow['ex_title'].' Result '.$i; ?>
                            </a>
                        <?php 
                            $i--;
                        }
                    }
                    else
                    { ?>
                        <a href="#" class="pl-3">You are not taking exam yet</a>
                    <?php }
                    
                   ?>

                    
                </li>


                <!-- <li class="app-sidebar__heading">FEEDBACKS</li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#feedbacksModal" >
                        Add Feedbacks                        
                    </a>
                </li> -->
                
            </ul>
        </div>
    </div>
</div>  
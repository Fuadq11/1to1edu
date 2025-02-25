
<style>
    .exam-selects{
        min-height: 50vh;
    }
    label{
        font-size: 22px;
        color: black;
    }
    #examStartBtn{

    }
</style>
<div class="app-main__outer">
    <div id="refreshData">
        <div class="container">
            <div class="exam-selects d-flex justify-content-center flex-direction-column">
                <div class="contents mt-5">
                    <div class="form-group">
                        <label for="types">Select Exam Type: </label>
                        <select name="" id="types" class="form-control">
                            <option value="">Select Exam Type</option>
                            <?php 
                                $examTypes = $conn->query("select * from exam_types");
                                while($type = $examTypes->fetch(PDO::FETCH_ASSOC)){ ?>
                                <option value="<?=$type['type_id']?>"><?=$type['name']?></option>
                        <?php 
                            }
                            ?>
                        </select>
                    </div> 
                    <div class="form-group" id="exams-form">
                        <label for="exams">Select Exam: </label>
                            <select name="exams" id="exams" class="form-control">

                            </select>
                    </div>
                    <div class="form-group">
                        <button id="examStartBtn" class="btn btn-primary">
                            Start Exam
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- <script src="js/jquery.js"></script> -->
<script type="text/javascript">




</script>
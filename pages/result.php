<?php 
 if(isset($_GET['id']) && empty($_GET['id'])==false && isset($_GET['s_id']) && empty($_GET['s_id'])==false){
    $examId = $_GET['id'];
    $session_id = $_GET['s_id'];
    $selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$examId' ")->fetch(PDO::FETCH_ASSOC);
    function answer($typ, $answ) {
        if ($typ == 0) {
            switch ($answ) {
                case "a": return "exam_ch1";
                case "b": return "exam_ch2";
                case "c": return "exam_ch3";
                case "d": return "exam_ch4";
                default: return "exam_answer";
            }
        } else {
            return "exam_answer";
        }
    }
 ?>

<!-- UI SECTION START -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<div class="app-main__outer">
<div class="app-main__inner">
<div class="container my-4">
    <div class="mb-4">
        <h2 class="text-primary"><?= $selExam['ex_title'] ?></h2>
        <p><?= $selExam['ex_description'] ?></p>
       
    </div>

    <?php
        $modules = [
            1 => "Section 1, Module 1: Reading and Writing",
            2 => "Section 1, Module 2: Reading and Writing",
            3 => "Section 2, Module 1: Math",
            4 => "Section 2, Module 2: Math"
        ];
    ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                <h5 class="card-title">Your Answers</h5>

<?php
    $arr[1]="<i class='bi bi-book'></i> Section 1, Module 1: Reading and Writing";
    $arr[2]="<i class='bi bi-book'></i> Section 1, Module 2: Reading and Writing";
    $arr[3]="<i class='bi bi-calculator'></i> Section 2, Module 1: Math";
    $arr[4]="<i class='bi bi-calculator'></i> Section 2, Module 2: Math";

    for($k=1;$k<=4;$k++){
        echo "<h4 class='mt-5 mb-3 text-primary fw-bold'>{$arr[$k]}</h4>";

        $selQuest = $conn->query("SELECT * FROM exam_question_tbl eqt 
            LEFT JOIN exam_answers ea 
            ON eqt.eqt_id = ea.quest_id AND ea.axmne_id='$exmneId' AND ea.session_id = '$session_id' 
            WHERE eqt.exam_id='$examId' AND eqt.exam_part = '$k' 
            ORDER BY eqt.eqt_id ASC;");
        
        $i = 1;
        while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) {
            $questionText = $selQuestRow['exam_question'];
            $questionType = $selQuestRow['question_type'];
            $userAnswer = isset($selQuestRow['exans_answer']) ? strtolower(trim(strval($selQuestRow[answer($questionType, $selQuestRow['exans_answer'])]))) : null;
            $correctAnswer = strtolower(trim(strval($selQuestRow[answer($questionType, $selQuestRow['exam_answer'])])));

            $isCorrect = $userAnswer ==  $correctAnswer;
?>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold text-dark mb-3"><?php echo $i++ . ".) " . $questionText; ?></h6>

        <?php if ($userAnswer): ?>
            <div class="alert <?= $isCorrect ? 'alert-success' : 'alert-danger' ?> mb-2">
                <i class="bi <?= $isCorrect ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>"></i>
                <strong>Your Answer:</strong> <?= $userAnswer ?>
                <br>
                <?= $isCorrect ? '<span class="fw-semibold">Correct!</span>' : '<span class="fw-semibold">Wrong!</span>' ?>
            </div>
            <?php if (!$isCorrect): ?>
                <div class="alert alert-secondary">
                    <i class="bi bi-info-circle-fill"></i>
                    <strong>Correct Answer:</strong> <?= $correctAnswer ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-primary">
                <i class="bi bi-dash-circle"></i> <strong>Not Answered</strong>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php } } ?> 
            </div>
        </div>
    </div>
        <!-- RIGHT SCORE PANEL -->
        <div class="col-lg-4">
            <?php
                $scoreQuery = function ($parts) use ($conn, $exmneId, $examId, $session_id) {
                    return $conn->query("
                        SELECT * FROM exam_question_tbl eqt
                        INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id
                        WHERE eqt.exam_part IN ($parts)
                        AND LOWER(TRIM(eqt.exam_answer)) = LOWER(TRIM(ea.exans_answer))
                        AND ea.axmne_id='$exmneId' AND ea.exam_id='$examId' AND ea.session_id = '$session_id'
                    ");
                };

                $totalQuery = function ($parts) use ($conn) {
                    return $conn->query("
                        SELECT * FROM exam_question_tbl eqt
                        INNER JOIN exam_tbl et ON eqt.exam_id = et.ex_id
                        WHERE eqt.exam_part IN ($parts)
                    ");
                };

                $rightMath = $scoreQuery("3,4")->rowCount();
                $rightEn = $scoreQuery("1,2")->rowCount();
                $allMath = $totalQuery("3,4")->rowCount();
                $allEn = $totalQuery("1,2")->rowCount();

                $calculateScore = function($correct, $total) {
                    if ($total == 0) return 0;
                    $score = ($correct / $total) * 600;
                    return min(800, 200 + ceil($score / 10) * 10);
                };

                $math_score = $calculateScore($rightMath, $allMath);
                $en_score = $calculateScore($rightEn, $allEn);
                $total_score = $math_score + $en_score;
            ?>

            <div class="card bg-light mb-3">
                <div class="card-body">
                    <h5>Reading & Writing Score</h5>
                    <h3 class="text-success"><?= $en_score ?></h3>
                </div>
            </div>
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <h5>Math Score</h5>
                    <h3 class="text-success"><?= $math_score ?></h3>
                </div>
            </div>
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <h5>Total Score</h5>
                    <h3 class="text-primary"><?= $total_score ?></h3>
                </div>
            </div>
            <div class="card bg-info text-white mb-2">
                <div class="card-body">
                    <h6>Reading & Writing Correct</h6>
                    <h4><?= $rightEn ?></h4>
                </div>
            </div>
            <div class="card bg-info text-white mb-2">
                <div class="card-body">
                    <h6>Math Correct</h6>
                    <h4><?= $rightMath ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php 
    } else {
        echo "<script>window.location.href='index.php';</script>";
    }

?>

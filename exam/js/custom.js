var allquestions = $(".question");

function showOnlyQuestion(number) {

	thisquestion = $(".question[data-questionnumber='" + number + "']");
	allquestions.hide();
	allquestions.removeClass("active");
	thisquestion.show();
	thisquestion.addClass("active");
	
	$("#current-question").html(number+1);
	updateButtons();
}

function initialiseQuestions() {

		firstquestion = $(".question").first().data("questionnumber");
		showOnlyQuestion(firstquestion);

}
///////////////////////////////////////////////////////////////////////////
function endQuestion(){
	$.ajax({
		url: "query/endExamPart.php",
		method: "post",
		data: {act:"endExamPart",exam_id:exam_id},
		dataType: "json"
	
	})
}

function nextQuestion() {

	var activeQuestion = $(".question.active").data("questionnumber");
	var newQuestion = activeQuestion + 1;
	if (newQuestion < totalQuestions) { showOnlyQuestion(newQuestion); };
	if($("#examEndPart").val()==2){
		if(activeQuestion == totalQuestions-1){
			let ex_part = $("#examPart").val();
			if(ex_part==4){
				Swal.fire({
					title: 'Exam ended!',
					text: "Your answers successfully saved!",
					icon: 'success',
					allowOutsideClick: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Exit'
				}).then((result) => {
				if (result.value) {
					$.ajax({
						url: "query/endExamPart.php",
						method: "post",
						data: {act:"end",exam_id:exam_id},
						dataType: "json",
						success: function(data){
							if(data.status=="success"){
								window.location.href='../index.php';
							}else{
								window.location.reload();
							}
						},
						error: function(data){
							window.location.reload();
						}
					})
				   
				}
		
				});
			}else{

			
			Swal.fire({
				title: 'This module ended',
				text: "Your answers successfully saved!",
				icon: 'success',
				allowOutsideClick: false,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Next Module'
			}).then((result) => {
			if (result.value) {
				endQuestion();
				window.location.href='index.php?page=exam&id=' + exam_id;
			}

			});
		}
	}
}

}

function previousQuestion() {
	var activeQuestion = $(".question.active").data("questionnumber");
	var newQuestion = activeQuestion - 1;
	if (newQuestion >= 0) { showOnlyQuestion(newQuestion); }
}

function updateButtons() {
	var activeQuestion = $(".question.active").data("questionnumber");
	$(".nextButton").show();
	$(".previousButton").hide();
	if (activeQuestion == 0) {
		$(".previousButton").hide();
	}
	else {
		$(".previousButton").show();
	}

}

var autoSave = null;
/////////////////////////////////////////////////////////////////////////
$(document).ready(function () {
	initialiseQuestions();
	$('body').on('click touchstart tap', '.question_answer', function () {
		var qname = $(this).attr('data-question-id');
		var value = $(this).attr('data-answer-value');
		$('input[type="radio"][name="question[' + qname + ']"][value="' + value + '"]').prop('checked', true);
		$(this).prop('checked', false);
		$('.selected-answer[data-question-id="' + qname + '"]').removeClass('selected-answer');
		$(this).addClass('selected-answer');
		saveAnswer(qname,exam_id,0);
		
	});

	$('body').keydown(function (event) {
		if (event.which == 37) {
			event.preventDefault();
			$(".previousButton").click();
		}
		if (event.which == 39) {
			event.preventDefault();
			$('.nextButton').click();
		}
	});

	$(".nextButton").click(function (e) {
		nextQuestion();
		e.preventDefault();
	});

	$(".previousButton").click(function (e) {
		previousQuestion();
		e.preventDefault();
	});

	$('.btn-submit-completed').click(function () {
		$('.submitButton').click();
	});
	// answered question markup 
	question_markup();
	function question_markup(){
		$.ajax({
			url: "query/ansQuestionMark.php",
			method: "post",
			data:{act:"selectQuestions"},
			dataType: "json",
			success: function(data){
				if(data.status=="success"){
					$(".bottombar-questions").each(function(){
						
						if(data.questionIds.includes(Number($( this ).attr("data-question")))){
							$( this ).addClass("bottombar-highlight");
						}
					})
				}else{
					console.log("error");
				}		
			}
		})
	}
// save question answer
function saveAnswer(question_id,exam_id,type){
	let answer = null;
	if(type==0){
		answer = $(`input[name='question[${question_id}]']:checked`).val();
	}else if(type==1){
		answer = $(`input[name='question[${question_id}]']`).val();
	}
	 if(answer!=null){
		$.ajax({
			url: '../query/saveAnswer.php',
			method: "post",
			data: {act:"save",question_id:question_id,exam_id:exam_id,answer:answer},
			success: function(data){
				data = JSON.parse(data);
				if(data.res == "success"){
					
					$(".bottombar-questions[data-question='"+question_id+"']").addClass("bottombar-highlight");
				}else if(data.res == "error"){
					alert("error");
					//error
				}else{
					alert("error");
				}
			},
			error: function(data){
				alert("error");
			}
		})
	 }
	
}
$('.open-question-asnwer input').on("input",function(){
	let q_id = $( this ).attr("data-question-id");
	saveAnswer(q_id,exam_id,1);
})
});

	// end of question markup


function updateCountdown() {
    $.ajax({
		url: "../query/examTime.php",
        method: 'post',
		data: {exam_id: exam_id,part: part},
		dataType : "json",
        success: function(data) {
            let remainingTime = data.remaining_time;
            if (remainingTime <= 0) {
				document.getElementById("global_watch").innerHTML = "Time is up!";

				if(data.examstatus==1){
					Swal.fire({
						title: 'Current Module 1 ended!',
						text: "Your answers successfully saved!",
						icon: 'success',
						allowOutsideClick: false,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Continue'
					}).then((result) => {
					if (result.value) {
					  
					   window.location.href='index.php?page=exam&id=' + exam_id;
					}
			
					});
				}else if(data.examstatus == 2){
					Swal.fire({
						title: 'Current Section 1 ended',
						text: "Your answers successfully saved!",
						icon: 'success',
						allowOutsideClick: false,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Continue'
					}).then((result) => {
					if (result.value) {
					  
					   window.location.href='break_time.php?page=exam&id=' + exam_id;
					}
			
					});
				}else if(data.examstatus==3){
						Swal.fire({
							title: 'Current Module 2 ended!',
							text: "Your answers successfully saved!",
							icon: 'success',
							allowOutsideClick: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'Continue'
						}).then((result) => {
						if (result.value) {
							window.location.href='index.php?page=exam&id='+ exam_id;
						}
						});	
				} else if(data.examstatus==4){
					Swal.fire({
						title: 'Exam ended!',
						text: "Your answers successfully saved!",
						icon: 'success',
						allowOutsideClick: false,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Exit'
					}).then((result) => {
					if (result.value) {
					  
					   window.location.href='../index.php';
					}
			
					});
				}
                

            } else {
				
                let minutes = Math.floor(remainingTime / 60);

                let seconds = remainingTime % 60;
				if(seconds < 10){
					seconds = "0"+seconds;
				}
                document.getElementById("global_watch").innerHTML = `${minutes} : ${seconds}`;
                setTimeout(updateCountdown, 1000);
            }
		},
		error: function(error){
			console.error("Error:", error.responseText);
		}
        })
        
}

updateCountdown();





/////////////////////////////////////////////////////////////////////////
// Questions show

$("#questions-btn").click(function(){
	$("#question-modal").toggleClass("modal-active")
})


$("#reference-btn").click(function(){
	$("#reference-modal").toggleClass("modal-active")
})
$("#reference-close").click(function(){
	$("#reference-modal").removeClass("modal-active");
})

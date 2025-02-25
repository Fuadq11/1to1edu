//////////////////////////////////////////////////////////////////////////
// * Stopwatch class {{{

////////////////////////////////////////////////////////////////////////


var allquestions = $(".question");

function showOnlyQuestion(number) {

	//Stop all the stopwatches.
	//console.log("show question : ", number);
	thisquestion = $(".question[data-questionnumber='" + number + "']");
	allquestions.hide();
	allquestions.removeClass("active");
	thisquestion.show();
	thisquestion.addClass("active");
	$('.bottombar-highlight').removeClass('bottombar-highlight');
	$(".bottombar-questions[data-questionnumber='" + number + "']").addClass('bottombar-highlight');

	//Start/resume the appropriate watch and set its listener to update
	//every second
	$("#current-question").html(number);
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
	if (newQuestion <= totalQuestions) { showOnlyQuestion(newQuestion); };
	if($("#examEndPart").val()==2){
		if(activeQuestion == totalQuestions){
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

function previousQuestion() {
	var activeQuestion = $(".question.active").data("questionnumber");
	var newQuestion = activeQuestion - 1;
	if (newQuestion >= 1) { showOnlyQuestion(newQuestion); }
}

function updateButtons() {
	var activeQuestion = $(".question.active").data("questionnumber");
	$(".nextButton").show();
	$(".previousButton").hide();
	

	if (activeQuestion == totalQuestions) {

		// $(".nextButton").hide();

		
		// $(".fakeSubmitButton").show();

	}

	if (activeQuestion == 1) {
		$(".previousButton").hide();
	}
	else {
		$(".previousButton").show();
	}

}

// $(window).resize(function () {

// 	if (34 * $('.bottombar-questions').length > $(window).width() - 2 * $('.nextButton').width()) {
// 		$('.pagination').width($(window).width() - 2 * $('.nextButton').width() - 2 * $('.backscroll').width());
// 	} else {
// 		$('.forwardscroll').hide();
// 		$('.backscroll').hide();
// 	}
// });

var autoSave = null;
/////////////////////////////////////////////////////////////////////////
$(document).ready(function () {
	initialiseQuestions();
    // showOnlyQuestion(2);
	// if (34 * $('.bottombar-questions').length > $(window).width() - 2 * $('.nextButton').width()) {
	// 	$('.pagination').width($(window).width() - 2 * $('.nextButton').width() - 2 * $('.backscroll').width());
	// } else {
	// 	$('.forwardscroll').hide();
	// 	$('.backscroll').hide();
	// };

	// $('body').on('click touchstart tap', '.forwardscroll', function () {
	// 	$('ul').animate({
	// 		scrollLeft: '+=150'
	// 	}, 350);
	// });

	// $('body').on('click touchstart tap', '.backscroll', function () {
	// 	$('ul').animate({
	// 		scrollLeft: '-=150'
	// 	}, 350);
	// });



	$('body').on('click touchstart tap', '.question_answer', function () {
		var qname = $(this).attr('data-question-id');
		var value = $(this).attr('data-answer-value');
		$('input[type="radio"][name="question[' + qname + ']"][value="' + value + '"]').prop('checked', true);
		$(this).prop('checked', false);
		$('.selected-answer[data-question-id="' + qname + '"]').removeClass('selected-answer');
		$(this).addClass('selected-answer');

		// numberOfQuestionsAttempted++;
		// alert($('input[type="radio"][name="question[' + qname + ']"]:checked').val());
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

	$(".fakeSubmitButton").click(function (e) {

		// Check to see if there are any blank questions
		// Check time condition

		// var elapsedMin = globalWatch.getElapsed().hours * 60 + globalWatch.getElapsed().minutes;
		// var timeCondition = (examDurationMins - elapsedMin) > 1;
		// var questionCondition = numberOfQuestionsAttempted - $(".question").length < 0;

		// if (questionCondition || timeCondition) {
		// 	$('#exit-dialog').modal('show');
		// }
		// else {
		// 	$('.submitButton').click();
		// }

	});

	// $(".solutionButton").click(function (e) {
	// 	$(this).parent().parent().find(".solution").slideToggle();
	// 	e.preventDefault();
	// });

	function getQuestionsData() {
		var questions = [];
		$(".question").each(function () {

			// Make an object for each question
			// This should have the question ID, the user Answer and the time taken.

			questionObj = {};

			var question_id = $(this).data('questionid');
			var user_answer = $(this).find("input:checked").val();
			var time_taken = $(this).find(".timer").text().trim();

			if (user_answer == undefined) { var user_answer = "0"; }

			questionObj['question_id'] = question_id;
			questionObj['user_answer'] = user_answer;
			questionObj['time_taken'] = time_taken;

			if ($(this).hasClass("active")) {
				questionObj['active'] = true;
			}

			questions.push(questionObj);
		});

		return questions;

	}

	// var submitted = 0;
	// //console.log(submitted);
	// if (submitted == 0) {
	// 	$("#practice_form").on('submit', function (e) {

	// 		var form = this;
	// 		e.preventDefault();
	// 		$("body").addClass("loading");

	// 		getUpdatedFormData();

	// 		submitted = 1;
	// 		//console.log(submitted);

	// 		form.submit();
	// 	});

	// }

});

function updateCountdown() {
    $.ajax({
		url: "../query/examTime.php",
        method: 'post',
		data: {exam_id: exam_id,part: part},
		dataType : "json",
        success: function(data) {
			
			// data = JSON.parse(data);
            let remainingTime = data.remaining_time;
            if (remainingTime <= 0) {
				document.getElementById("global_watch").innerHTML = "Time is up!";

				if(data.examstatus==1){
					Swal.fire({
						title: 'Current Module ended!',
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
						title: 'Current Section ended',
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
							title: 'Current Module ended!',
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

// var time_left= Number(examTime)*60;
// // Update the count down every 1 second
// var x = setInterval(function() {

// 	time_left--;
//   var minutes= Math.floor(time_left / 60);
// 	var second = Math.floor(time_left % 60);

//   // Output the result in an element with id="demo"
//   document.getElementById("global_watch").innerHTML = minutes +":" +second;

//   // If the count down is over, write some text
//   if (time_left < 0) {
//     clearInterval(x);
//     document.getElementById("global_watch").innerHTML = "EXPIRED";
//   }
// }, 1000);

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
					// success
					alert("success");
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

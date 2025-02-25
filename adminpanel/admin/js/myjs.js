$(function(){
	$('a[rel*=facebox]').facebox();
});

if(window.location.href.includes("manage-exam-details")){
	
	document.addEventListener("DOMContentLoaded",function(){
		let img_id=1;
		document.querySelector("#addImgBtn").addEventListener("click",function(){
			let newImgElement = `<div class="multiple-imgs" data-img-id="${img_id}"><input type="file" name="questionImage[]" accept="Image/*"> <button type="button" class="deleteImgBtn btn btn-danger" data-img-id="${img_id}" onclick="deleteImgElement(this)">Delete</button> </div>`;
			$("#questionImgs").append(newImgElement);
			img_id++;
		})

		

		// document.querySelectorAll(".deleteImgBtn").forEach(btn=>{
		// 	alert("adjndaj");
		// })
		// $(".deleteImgBtn").on("click",function(){
			
		// })

			
		

	})
	function deleteImgElement(btn,id){
		$(btn).closest(".multiple-imgs").remove();
	}

	

	function questionChange(type){
		if(type==0){
			$("#question-data").html(multiple_choice);
			CKEDITOR.replace('choice_A');
			CKEDITOR.replace('choice_B');
			CKEDITOR.replace('choice_C');
			CKEDITOR.replace('choice_D');
		}
		if(type==1){
			$("#question-data").html(open_question);
		}
	}
	let multiple_choice =`<div class="form-group">
                  <label><b>Choice A</b></label>
                    <textarea name="choice_A" id="" class="form-control" height="100" required></textarea>
                </div>

                <div class="form-group">
                  <label><b>Choice B</b></label>
                  <textarea name="choice_B" id="" class="form-control" required></textarea>                  
                </div>

                <div class="form-group">
                  <label><b>Choice C</b></label>
                  <textarea name="choice_C" id="" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                  <label><b>Choice D</b></label>
                  <textarea name="choice_D" id="" class="form-control" required></textarea>
                </div>
				<div class="form-group">
                  <label><b>Correct Answer</b></label>
                  <select name="correctAnswer" id="" class="form-control" required>
                      <option value="a">A</option>
                      <option value="b">B</option>
                      <option value="c">C</option>
                      <option value="d">D</option>
                  </select>
              </div>`;
let open_question =`<div class="form-group">
						<label><b>Correct Answer: </b></label>
						<input type="" name="correctAnswer" id="" class="form-control" placeholder="Input correct answer" autocomplete="off" required>
					</div>	`;

// for update question form
function up_questionChange(type){
	if(type==0){
		$("#up_question-data").html(up_multiple_choice);
		// CKEDITOR.replace('up_question');
		try {
			CKEDITOR.instances['up_choice_A'].destroy(true);
			CKEDITOR.instances['up_choice_B'].destroy(true);
			CKEDITOR.instances['up_choice_C'].destroy(true);
			CKEDITOR.instances['up_choice_D'].destroy(true);
		} catch (e) { }
		
			CKEDITOR.replace('up_choice_A');
			CKEDITOR.replace('up_choice_B');
			CKEDITOR.replace('up_choice_C');
			CKEDITOR.replace('up_choice_D');
		

	}
	if(type==1){
		try {
			CKEDITOR.instances['up_choice_A'].destroy(true);
			CKEDITOR.instances['up_choice_B'].destroy(true);
			CKEDITOR.instances['up_choice_C'].destroy(true);
			CKEDITOR.instances['up_choice_D'].destroy(true);
		} catch (e) { }
		$("#up_question-data").html(up_open_question);
	}

}
let up_multiple_choice =`<div class="form-group">
				  <label><b>Choice A</b></label>
					<textarea name="up_choice_A" id="" class="form-control" height="100" required></textarea>
				</div>

				<div class="form-group">
				  <label><b>Choice B</b></label>
				  <textarea name="up_choice_B" id="" class="form-control" required></textarea>                  
				</div>

				<div class="form-group">
				  <label><b>Choice C</b></label>
				  <textarea name="up_choice_C" id="" class="form-control" required></textarea>
				</div>

				<div class="form-group">
				  <label><b>Choice D</b></label>
				  <textarea name="up_choice_D" id="" class="form-control" required></textarea>
				</div>
				<div class="form-group">
                  <label><b>Correct Answer</b></label>
                  <select name="up_correctAnswer" id="" class="form-control" required>
                      <option value="a">A</option>
                      <option value="b">B</option>
                      <option value="c">C</option>
                      <option value="d">D</option>
                  </select>
              </div>`;
			  let up_open_question = `
					<div class="form-group">
						<label><b>Correct Answer: </b></label>
						<input type="" name="up_correctAnswer" id="" class="form-control" placeholder="Input correct answer" autocomplete="off" required>
					</div>	 
			  `
				
}


function generatePDF(fullname,exam_title,score) {
    // Import jsPDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Title
    doc.setFont("helvetica", "bold");
    doc.setFontSize(24);
    doc.text("Exam Result", 20, 20);

    // Table Headers
    doc.setFontSize(18);
    doc.text("Full Name: ", 20, 40);
    doc.text("Exam Title: ", 20, 60);
    doc.text("Score: ", 20, 80);
    doc.setFont("helvetica", "normal");
            doc.text(fullname, 60, 40);
            doc.text(exam_title, 60, 60);
            doc.text(score, 60, 80);
    doc.save(fullname+" Exam_Results.pdf");
}
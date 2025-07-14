// Admin Log in
$(document).on("submit","#adminLoginFrm", function(){
   $.post("query/loginExe.php", $(this).serialize(), function(data){
      if(data.res == "invalid")
      {
        Swal.fire(
          'Invalid',
          'Please input valid username / password',
          'error'
        )
      }
      else if(data.res == "success")
      {
        $('body').fadeOut();
        window.location.href='home.php';
      }
   },'json');

   return false;
});



// Add Course 
$(document).on("submit","#addCourseFrm" , function(){
  $.post("query/addCourseExe.php", $(this).serialize() , function(data){
  	if(data.res == "exist")
  	{
  		Swal.fire(
  			'Already Exist',
  			data.course_name.toUpperCase() + ' Already Exist',
  			'error'
  		)
  	}
  	else if(data.res == "success")
  	{
  		Swal.fire(
  			'Success',
  			data.course_name.toUpperCase() + ' Successfully Added',
  			'success'
  		)
          // $('#course_name').val("");
          refreshDiv();
            setTimeout(function(){ 
                $('#body').load(document.URL);
             }, 2000);
  	}
  },'json')
  return false;
});

// Update Course
$(document).on("submit","#updateCourseFrm" , function(){
  $.post("query/updateCourseExe.php", $(this).serialize() , function(data){
     if(data.res == "success")
     {
        Swal.fire(
            'Success',
            'Selected course has been successfully updated!',
            'success'
          )
          refreshDiv();
     }
  },'json')
  return false;
});


// Delete Course
$(document).on("click", "#deleteCourse", function(e){
    e.preventDefault();
    var id = $(this).data("id");
     $.ajax({
      type : "post",
      url : "query/deleteCourseExe.php",
      dataType : "json",  
      data : {id:id},
      cache : false,
      success : function(data){
        if(data.res == "success")
        {
          Swal.fire(
            'Success',
            'Selected Course successfully deleted',
            'success'
          )
          refreshDiv();
        }
      },
      error : function(xhr, ErrorStatus, error){
        console.log(status.error);
      }

    });
    
   

    return false;
  });


// Delete Exam
$(document).on("click", "#deleteExam", function(e){
    e.preventDefault();
    var id = $(this).data("id");
     $.ajax({
      type : "post",
      url : "query/deleteExamExe.php",
      dataType : "json",  
      data : {id:id},
      cache : false,
      success : function(data){
        if(data.res == "success")
        {
          Swal.fire(
            'Success',
            'Selected Course successfully deleted',
            'success'
          )
          refreshDiv();
        }
      },
      error : function(xhr, ErrorStatus, error){
        console.log(status.error);
      }

    });
    
   

    return false;
  });



// Add Exam 
$(document).on("submit","#addExamFrm" , function(){
  $.post("query/addExamExe.php", $(this).serialize() , function(data){
    if(data.res == "noSelectedCourse")
   {
      Swal.fire(
          'No Course',
          'Please select course',
          'error'
       )
    }
    if(data.res == "noSelectedEnTime")
   {
      Swal.fire(
          'No Time Limit',
          'Please select English Part time limit',
          'error'
       )
    }
    if(data.res == "noSelectedMathTime")
      {
         Swal.fire(
             'No Time Limit',
             'Please select Math Part time limit',
             'error'
          )
       }
  //   if(data.res == "noDisplayLimit")
  //  {
  //     Swal.fire(
  //         'No Display Limit',
  //         'Please input question display limit',
  //         'error'
  //      )
  //   }

     else if(data.res == "exist")
    {
      Swal.fire(
        'Already Exist',
        data.examTitle.toUpperCase() + '<br>Already Exist',
        'error'
      )
    }
    else if(data.res == "success")
    {
      Swal.fire(
        'Success',
        data.examTitle.toUpperCase() + '<br>Successfully Added',
        'success'
      )
          $('#addExamFrm')[0].reset();
          $('#course_name').val("");
          refreshDiv();
    }
    // console.error(data);
  },'json')
  return false;
});
// Exam status changer
$(document).on("change",".exam_status_changer" , function(){    
    let status = 0;
    let exam_id = $(this).attr("data-id");
    let checkbox = $(this);
    let label = checkbox.siblings('label.custom-control-label');
    
    if(checkbox.is(":checked")){
        status = 1;
        label.text("Active");
    } else {
        status = 0;
        label.text("Inactive");
    }

    $.ajax({
        url: "query/updateExamExe.php",
        method: "post",
        data: {act:"exam_status", ex_id: exam_id, status: status},
        dataType: 'json',
        success: function(data){
            if(data.res == "success"){
                Swal.fire({
                    title: 'Success',
                    text: 'Exam status updated successfully!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                // Revert the checkbox state if update failed
                checkbox.prop('checked', !checkbox.is(':checked'));
                if(checkbox.is(':checked')) {
                    label.text("Active");
                } else {
                    label.text("Inactive");
                }
                
                Swal.fire(
                    'Error',
                    'Failed to update exam status',
                    'error'
                );
            }
        },
        error: function(xhr, status, error){
            // Revert the checkbox state on error
            checkbox.prop('checked', !checkbox.is(':checked'));
            if(checkbox.is(':checked')) {
                label.text("Active");
            } else {
                label.text("Inactive");
            }
            
            Swal.fire(
                'Error',
                'Something went wrong. Please try again.',
                'error'
            );
        }
    });
})

// Update Exam 
$(document).on("submit","#updateExamFrm" , function(){
  $.post("query/updateExamExe.php", $(this).serialize() , function(data){
    if(data.res == "success")
    {
      Swal.fire(
          'Update Successfully',
          data.msg + ' <br>are now successfully updated',
          'success'
       )
          refreshDiv();
    }
    else if(data.res == "failed")
    {
      Swal.fire(
        "Something's went wrong!",
         'Somethings went wrong',
        'error'
      )
    }
   
  },'json')
  return false;
});

// Update Question
$(document).on("submit","#updateQuestionFrm" , function(event){
  event.preventDefault();
  let form = $('#updateQuestionFrm')[0];
  let formData = new FormData(form);
  $.ajax({
    url: "query/updateQuestionExe.php", 
    method: 'post',
    data: formData, 
    cache: false,
    contentType: false,
    processData: false, 
    success: function(data){
       data =  JSON.parse(data);
   if(data.res == "success")
    {
      Swal.fire(
        'Success',
         'Selected question has been successfully updated!',
        'success'
      ).then((result) => {
        if (result.value) {
        // $('#updateQuestionFrm').reset();
        // refreshDiv();
        window.location.reload();
        }
      })
    }
  },
  error: function(){
    Swal.fire(
      'Error',
      'Selected question could not updated!',
      'error'
   )
  }
})
// return false;
});


// Delete Question
$(document).on("click", "#deleteQuestion", function(e){
    e.preventDefault();
    var id = $(this).data("id");
     $.ajax({
      type : "post",
      url : "query/deleteQuestionExe.php",
      dataType : "json",  
      data : {id:id},
      cache : false,
      success : function(data){
        if(data.res == "success")
        {
          Swal.fire(
            'Deleted Success',
            'Selected question successfully deleted',
            'success'
          )
          refreshDiv();
        }
      },
      error : function(xhr, ErrorStatus, error){
        console.log(status.error);
      }

    });
    
   

    return false;
  });


// Add Question 
$(document).on("submit","#addQuestionFrm" , function(event){
  event.preventDefault();
  $('#addQuestionFrm').validate({ // initialize the plugin
    rules: {
      question: {
            required: true
        }
    }
});
  let form = $('#addQuestionFrm')[0];
  let formData = new FormData(form);
  let add_question_res = $.ajax({
    url: "query/addQuestionExe.php", 
    method: 'post',
    data: formData,
    dataType: 'json', 
    cache: false,
    contentType: false,
    processData: false,
    async:false 
});
add_question_res = add_question_res.responseJSON;
if(add_question_res.res == "exist")
  {
    Swal.fire(
        'Already Exist',
        add_question_res.msg + ' question <br>already exist in this exam',
        'error'
     )
  }
  else if(add_question_res.res == "success")
  {
    Swal.fire(
      'Success',
      add_question_res.msg + ' question <br>Successfully added',
      'success'
    ).then((result) => {
      if (result.value) {
      window.location.reload();
      }
    })
  }else if(add_question_res.res == "error"){
    Swal.fire(
      'Error',
      add_question_res.msg + ' Error occured',
      'error'
   )
  }

  // return false;
});
// delete img in update form
function question_update_dlt_img(btn,img_id,img_name){
  $.ajax({
    url: "query/updateQuestionExe.php", 
    method: 'post',
    data: {act:"delete",img_id:img_id,img_name:img_name}, 
    success: function(data){
      data =  JSON.parse(data);
      if(data.res == "success")
        {
          Swal.fire(
            'Success',
             'Image Successfully Deleted',
            'success'
          )
          $(btn).closest(".multiple-imgs").remove();
        }else{
          Swal.fire(
            'Could not delete',
              '',
            'error'
         )
        }
    }
  })
}

// Add Examinee
$(document).on("submit","#addExamineeFrm" , function(){
  $.post("query/addExamineeExe.php", $(this).serialize() , function(data){
    if(data.res == "noGender")
    {
      Swal.fire(
          'No Gender',
          'Please select gender',
          'error'
       )
    }
    else if(data.res == "noCourse")
    {
      Swal.fire(
          'No Course',
          'Please select course',
          'error'
       )
    }
    else if(data.res == "noLevel")
    {
      Swal.fire(
          'No Year Level',
          'Please select year level',
          'error'
       )
    }
    else if(data.res == "fullnameExist")
    {
      Swal.fire(
          'Fullname Already Exist',
          data.msg + ' are already exist',
          'error'
       )
    }
    else if(data.res == "emailExist")
    {
      Swal.fire(
          'Email Already Exist',
          data.msg + ' are already exist',
          'error'
       )
    }
    else if(data.res == "success")
    {
      Swal.fire(
          'Success',
          data.msg + ' are now successfully added',
          'success'
       ).then((result) => {
        if (result.value) {
          setTimeout(() => {
            window.location.reload();
          }, 300);
         
        }})
        setTimeout(() => {
          window.location.reload();
        }, 3000);
        $('#addExamineeFrm')[0].reset();
    }
    else if(data.res == "failed")
    {
      Swal.fire(
          "Something's Went Wrong",
          '',
          'error'
       )
    }


    
  },'json')
  return false;
});



// Update Examinee
$(document).on("submit","#updateExamineeFrm" , function(){
  $.post("query/updateExamineeExe.php", $(this).serialize() , function(data){
     if(data.res == "success")
     {
        Swal.fire(
            'Success',
            data.exFullname + ' <br>has been successfully updated!',
            'success'
          ).then((result) => {
            if (result.value) {
              setTimeout(() => {
                window.location.reload();
              }, 300);
             
            }})
            setTimeout(() => {
              window.location.reload();
            }, 3000);
          
     }
  },'json')
  return false;
});


function refreshDiv()
{
  $( document ).ready(function() {
  $('#tableList').load(document.URL +  ' #tableList');
  $('#refreshData').load(document.URL +  ' #refreshData');
});
}





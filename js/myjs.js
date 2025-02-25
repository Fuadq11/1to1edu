
$(document).on("click","#startQuiz", function(){
	  var thisId = $(this).data('id');
    $.ajax({
      type : "post",
      url : "query/selExamAttemptExe.php",
      dataType : "json",  
      data : {thisId:thisId},
      cache : false,
      success : function(data){
        if(data.res == "alreadyExam")
        {
          Swal.fire(
            'Already Taken ',
            'you already take this exam',
            'error'
          )
        }
        else if(data.res == "takeNow")
        {
          Swal.fire({
            title: 'Are you sure?',
            text: 'You want to take this exam now, your time will start automaticaly',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, start now!'
       }).then((result) => {
        if (result.value) {       
          window.location.href="exam/index.php?page=exam&id="+thisId;
          return false;
        }
       });
          
        }
      },
      error : function(xhr, ErrorStatus, error){
        console.log(status.error);
      }

    });
	
	return false;
})



// Reset Exam Form
$(document).on("click","#resetExamFrm", function(){
      $('#submitAnswerFrm')[0].reset();
      return false;
});





// Select Time Limit
// var mins
// var secs;

// function cd() {
//   var timeExamLimit = $('#timeExamLimit').val();
//   mins = 1 * m("" + timeExamLimit); // change minutes here
//   secs = 0 + s(":01"); 
//   redo();
// }

// function m(obj) {
//   for(var i = 0; i < obj.length; i++) {
//       if(obj.substring(i, i + 1) == ":")
//       break;
//   }
//   return(obj.substring(0, i));
// }

// function s(obj) {
//   for(var i = 0; i < obj.length; i++) {
//       if(obj.substring(i, i + 1) == ":")
//       break;
//   }
//   return(obj.substring(i + 1, obj.length));
// }

// function dis(mins,secs) {
//   var disp;
//   if(mins <= 9) {
//       disp = " 0";
//   } else {
//       disp = " ";
//   }
//   disp += mins + ":";
//   if(secs <= 9) {
//       disp += "0" + secs;
//   } else {
//       disp += secs;
//   }
//   return(disp);
// }

// function redo() {
//   secs--;
//   if(secs == -1) {
//       secs = 59;
//       mins--;
//   }
//   document.cd.disp.value = dis(mins,secs); 
//   if((mins == 0) && (secs == 0)) {
//     $('#examAction').val("autoSubmit");
//      $('#submitAnswerFrm').submit();
//   } else {
//     cd = setTimeout("redo()",1000);
//   }
// }

// function init() {
//   cd();
// }
// window.onload = init;


$(document).ready(function(){
  $('#exams-form').hide();
  $("#examStartBtn").hide();
  $('#types').on("change",function () {
      var exam_type = $(this).find('option:selected').val();
      if(exam_type!=0){
        $.ajax({
          url : "query/ajax.php",
          method : "POST",
          data : {exam_type:exam_type,act:'exams'},
          dataType : 'json',
          success : function (data) {
              if(data.status=="success"){
                $("#exams").html("");
                data.exams.forEach(el=>{
                  $("#exams").append(`<option value="${el.id}">${el.name}</option>`);
                });
                $("#examStartBtn").show();
                $('#exams-form').show();
                
              }else if(data.status=="empty"){
                $("#exams").html("<option value='0'>Exam not found</option>");
                $('#exams-form').show();

              }
              
          },
          error : function(data){
            console.log(data);
          }
        });
    }
  }); 

  $('#exams').on("change",function () {
    
    $('#examStartBtn').attr("data-link",link);
  });

  $("#examStartBtn").on("click",function(){
    var exam_id = $('#exams').find('option:selected').val();
    link = "exam/index.php?page=exam&id="+exam_id;
    window.location.href=link;
  })
});
$(function() {

})(jQuery);




$(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
  });
});


function invitemodel()
{  
   $('#invite_button"]').prop('disabled', true);
  var e = document.getElementById("job");
  var jobid = e.options[e.selectedIndex].value;
  var userid=document.getElementById("model_id").value; 


  if(jobid!='')
  {
   $.ajax({
     type: "POST",
     url:baseurl+'account/invitation',
     data: "modelid="+model_id+"&jobid="+jobid,
     success: function(data)
     {                    
       console.log(data);
     }
  });
 }
 else{
  alert('Select JOb first');
 }
 
}
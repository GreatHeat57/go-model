
$(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
  });
});


 function invitemodel()
{  
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
function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
};

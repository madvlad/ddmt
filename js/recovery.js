var shootOutEmail = function(){
  var form = $("#recoveryEmail");
  $.ajax({
    type: "POST",
    url: form.attr('action'),
    data: form.serialize(),
    success: function(){
       window.alert("Recovery email sent!");
    }
   });
  
}

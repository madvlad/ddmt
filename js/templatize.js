var makeTemplate = function (name){
  var myNs = {};
  var y = window.confirm("Are you sure you want to make a template?");
   myNs["id"] = name;
  if(y == true){
  
  var tname = window.prompt("Enter template name","defaultOverwrite");
  if(tname != null){
  $.ajax({
    type: "POST",
    url: "makeTemplate.php",
    data: {"id": name, "template": tname},
    success: function(data){
       window.alert("Template " + data +  " created");
    }
   });

  }
 }
};

var deleteUser = function (name){
  var myNs = {};
  var y = window.confirm("Are you sure you want to delete this user?");
  myNs["id"] = name;
  if(y == true){
  $.ajax({
    type: "POST",
    url: "deleteAdmin.php",
    data: {"id": name},
    success: function(data){
       window.alert("User " + data +  " deleted.");
		window.location.reload();
    }
   });

}
  
};

var deleteSess = function (name){
  var myNs = {};
  var y = window.confirm("Are you sure you want to delete this session?");
  myNs["id"] = name;
  if(y == true){
  $.ajax({
    type: "POST",
    url: "deleteTest.php",
    data: {"sessID": name},
    success: function(data){
       window.alert("Session " + data +  " deleted.");
		window.location.reload();
    }
   });

}
  
};

var deleteTemplate = function(name){
  var myNs = {};
  var y = window.confirm("Are you sure you want to delete this session?");
  myNs["id"] = name;
  if(y == true){
  $.ajax({
    type: "POST",
    url: "deleteBoardTemp.php",
    data: {"name": name},
    success: function(data){
       window.alert("Template " + data +  " deleted.");
      window.location.reload();
    }
   });


}

};

$(document).ready(function(){
var select = document.getElementById("numberOf");
select.onchange = (function(x){
    var val = select.value;
    var confeds = document.getElementById("confeds");
    confeds.options.length = 0;
    confeds.options[0] = new Option(0,0,true,false);
    for(var i = 1; i < val; i++){
        confeds.options[i] = new Option(i,i,false,false);
    }

    document.getElementById("ctA").style.visibility = "hidden";
    document.getElementById("ctB").style.visibility = "hidden";
    document.getElementById("ctC").style.visibility = "hidden";
    document.getElementById("ctD").style.visibility = "hidden";
    document.getElementById("ctE").style.visibility = "hidden";
    
});

var confeds = document.getElementById("confeds");
confeds.onchange = (function(x){
     document.getElementById("ctA").style.visibility = "hidden";
     document.getElementById("ctB").style.visibility = "hidden";
     document.getElementById("ctC").style.visibility = "hidden";
     document.getElementById("ctD").style.visibility = "hidden";
     document.getElementById("ctE").style.visibility = "hidden";

     var val = parseInt(confeds.value);
     switch(val){
       case 5:
         document.getElementById("ctE").style.visibility = "visible";
       case 4:
         document.getElementById("ctD").style.visibility = "visible";
       case 3:
         document.getElementById("ctC").style.visibility = "visible";
       case 2:
         document.getElementById("ctB").style.visibility = "visible";
       case 1:
         document.getElementById("ctA").style.visibility = "visible";
         break;
     }
});
document.getElementById("ctA").style.visibility = "hidden";
document.getElementById("ctB").style.visibility = "hidden";
document.getElementById("ctC").style.visibility = "hidden";
document.getElementById("ctD").style.visibility = "hidden";
document.getElementById("ctE").style.visibility = "hidden";
});

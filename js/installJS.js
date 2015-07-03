$(document).ready(function(){

document.getElementById('ap').onchange = (function(){
  var apc = document.getElementById('apc');  
  if(this.value !== apc.value){
    apc.style.backgroundColor = "red";
  }
  else{
    apc.style.backgroundColor = "white";
  }
});


document.getElementById('apc').onchange = (function(){
  var ap = document.getElementById('ap');
  if(this.value !== ap.value){
    this.style.backgroundColor = "red";
  }
  else{
    this.style.backgroundColor = "white";
  }
});

document.getElementById('adp').onchange = (function(){
  var apc = document.getElementById('adpc'); 
  if(this.value !== apc.value){
    apc.style.backgroundColor = "red";
  }
  else{
    apc.style.backgroundColor = "white";
  }
});


document.getElementById('adpc').onchange = (function(){
  var ap = document.getElementById('adp');
  if(this.value !== ap.value){
    this.style.backgroundColor = "red";
  }
  else{
    this.style.backgroundColor = "white";
  }
});

document.getElementById('installSystem').onclick= (function(){
  var okay = true;
  var inputs = document.getElementsByClassName("installIn");
  for(var i = 0; i < inputs.length; i++){
    if(inputs[i].value == ""){
      inputs[i].style.backgroundColor = "red";
      okay = false;
    }
    else{
      inputs[i].style.backgroundColor = "white";
    }

  }

});


var inputs = document.getElementsByClassName("installIn");
for(var j = 0; j < inputs.length; j++){
  if(!inputs[j].id){
    inputs[j].onchange = (function(){
      if(this.value == ""){
        this.style.backgroundColor = "red";
      }
      else{
        this.style.backgroundColor = "white";
      }
    });
  }

}

});

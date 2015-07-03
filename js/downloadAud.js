function downloadURL(url){
    console.log(url);
    var hiddenIFrameID = 'hiddenDownloader';
    var iframe = document.getElementById(hiddenIFrameID);
    if(iframe === null){
      iframe = document.createElement('iframe');
      iframe.id=hiddenIFrameID;
      iframe.style.display = 'none';
      document.body.appendChild(iframe);
	 }
    
    iframe.src = url;
}

$(document).ready(function(){
var labels = ['A','B','C','D','E','F'];

for(var ini = 0;  ini < labels.length; ini++){
   (function(){
   var i = ini;
	   var doid = "audDown" + labels[i];
   var dorc = document.getElementById(doid);
   if(dorc != null){
     $("#"+doid).on('click',function(sourceAud){
           var upid = "audSrc" + labels[i];
           var sourceAud = document.getElementById(upid);
           downloadURL(sourceAud.childNodes[0].src);
       });
   }
})();
}
});

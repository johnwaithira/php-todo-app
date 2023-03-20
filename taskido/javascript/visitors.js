let VisitHandLer = new XMLHttpRequest(); 
window.onload = () =>{
    VisitHandLer.open("GET", "./configuration/visitCounter.php");
    VisitHandLer.onload = () =>{
       if(VisitHandLer.readyState === XMLHttpRequest.DONE){
           if(VisitHandLer.status === 200){
             let data = VisitHandLer.response;
            // alert(data);
           }
       }
   }      
   VisitHandLer.send();
}
let currentMessage = document.getElementById('currentMessage');
let successtMessage = document.getElementById('successMessage');

if(currentMessage!=null){
  
    function messageDisplay() {
         currentMessage.style.opacity='0';
    }
    setTimeout("messageDisplay()", 3000); // 
}


if(successtMessage!=null){
    
    function messageDisplay() {
      successtMessage.style.opacity='0';
    }
    setTimeout("messageDisplay()", 3000);  
}

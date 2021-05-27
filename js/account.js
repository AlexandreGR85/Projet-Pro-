// déclaration des variables
let accountButton = document.getElementsByClassName('accountButton')[0];
let close = document.getElementById('close');
let modal = document.getElementsByClassName('modal')[0];
let logForm = document.getElementsByClassName('logForm')[0];
let fieldCreate = document.getElementsByClassName('fieldCreate')[0];
let createForm = document.getElementsByClassName('createForm')[0];
let token = document.getElementById('token');
let tokenCreate = document.getElementById('tokenCreate');
let myQuiz = document.getElementById('myQuiz');
let widthConnectedArray = document.getElementsByClassName('widthConnected');


// déclaration des fonctions

function requete() {
	
	let request = new XMLHttpRequest();
	
	request.onreadystatechange = function() {
		
		if (this.readyState == 4 && this.status == 200) {
		    
			let phpArray = request.response;
			token.value = null;
			token.value = phpArray.Token;
			tokenCreate.value = phpArray.Token;
			
			
		}
			
	}
 
	request.open('GET', 'index.php?controller=User&task=loginForm', true);
	request.responseType = 'json';
	request.send();
	
	
}

let modalClosing = function() {
   modal.classList.add('hide');
   if(logForm.classList.contains('hide')){
   createForm.classList.add('hide');
   logForm.classList.remove('hide');
   }
   
}

let modalOpening = function() {
   modal.classList.remove('hide');
   requete();
}

let suscribeFormDisplay = function() {
   logForm.classList.add('hide');
   createForm.classList.remove('hide');
   requete();
   
}

window.addEventListener("DOMContentLoaded", (event) => {
    
    close.addEventListener('click', modalClosing);
    
    if(accountButton!=null){
    accountButton.addEventListener('click', modalOpening);
    }
    fieldCreate.addEventListener('click', suscribeFormDisplay);
    
    
    if(myQuiz != null){
        
        for(let i=0; i< widthConnectedArray.length; i++){
            widthConnectedArray[i].style.width='25%';
        }
    }
})





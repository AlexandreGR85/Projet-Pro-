//******************************Dépendances***************************************
import StatusCheck from './class/StatusCheck.js'; 
import DisplayDeal from './class/DisplayDeal.js';
import NextClickDeal from './class/NextClickDeal.js';
import GameSummary from './class/GameSummary.js';

//******************************variables***************************************

// récupération des status des réponse (1 si bonne réponse, 0 si mauvais réponse)
let correctAnswer = document.getElementsByClassName('status1')[0];
let wrongAnswerArray=document.getElementsByClassName('status0');

// récupération du bouton next 
let next = document.getElementById('next');

// récupération de la période et du topic
if(document.getElementById('pid') != null && document.getElementById('tid') != null && document.getElementById('questionNum') != null){
	let pid =  document.getElementById('pid').innerHTML;
	let tid = document.getElementById('tid').innerHTML;
	let questionNum = document.getElementById('questionNum');
	let question = questionNum.innerHTML;
	
	
	let appreciation = document.getElementById("appreciation");
	let score = document.getElementById('displayScore');
	let totalQuestions = document.getElementById('totalQuestions');
	let questionEntitle = document.getElementById('questionEntitle');
	let responsesChoices = document.getElementById('responses_choices');
	let correctAnswerCorrection = document.getElementById('correctAnswerCorrection');
	let point = 0;
	
	//*************************instanciation des class******************************
	
	let statusCheck = new StatusCheck(correctAnswer);
	let displayDeal = new DisplayDeal();
	let newRequest = new XMLHttpRequest();
	let nextClickDeal = new NextClickDeal(next, newRequest, score, appreciation);
	
	
	// *****************************************************************************
	
	// *************************FONCTIONS*******************************************
	
	// *****************************************************************************
	
	
	
	// ********************
	function choiceOnClick(evt){
	    let choiceStatus = evt.target.myParam.innerHTML
			if(evt.target.myParam.classList.contains('status1')) {
				point++
				choiceStatus = true;
			}else{choiceStatus = false;}
		//Appel de la fonction statusCheckManage avec envoie en arguments du status de la réponse et du nombre de points
	    statusCheck.statusCheckManage(choiceStatus, correctAnswer);
	}
	
	// ********************
	function requete(){
	    
		let request = new XMLHttpRequest();
		request.onreadystatechange = function() {
			
			questionEntitle = document.getElementById('questionEntitle');
			
			if (this.readyState == 4 && this.status == 200) {
				let phpArray = request.response;
				totalQuestions.innerHTML = phpArray['totalOfQuestions'].length;
				document.getElementsByClassName('imagequestion')[0]['src'] = "/uploads/quizImg/" + phpArray['questions']['Pictures'];
				document.getElementsByClassName('imagequestion')[1]['src'] = "/uploads/quizImg/" + phpArray['questions']['Pictures'];
				questionEntitle.innerHTML = phpArray['questions']['Entitle'];
				
				questionNum.innerHTML = question
				tid = phpArray['questions']['Topics_ID'];
				pid = phpArray['questions']['Periods_ID'];
				let answers = phpArray['responses'];
				
				// effacement de ce qui se trouve dans la div 'response choices'
				responsesChoices.innerHTML = null
				
				// construction des paragraphes dans la div 'responses choices'
				for(let i=0; i<answers.length; i++){
			        let para 
			        para = document.createElement('p')
			        para.classList.add('status'+answers[i]['RightAnswer'])
			        para.textContent = answers[i]['Proposal']
			        responsesChoices.appendChild(para);
				}
			} 
		
			// mise à jour des valeurs de chacun des paragraphes dans la div 'responses choices'
			correctAnswer.innerHTML = document.getElementsByClassName('status1')[0].innerHTML;
			correctAnswerCorrection.innerHTML = correctAnswer.innerHTML;
			correctAnswer = document.getElementsByClassName('status1')[0];
			
			// écoute du click sur la bonne réponse et appel de la fonction correctAnswerOnClick
			correctAnswer.addEventListener('click', choiceOnClick, false)
			correctAnswer.myParam = correctAnswer;
		
			// écoute du click sur chacune des mauvaises réponses et appel de la fonction wrongAnswerOnClick
			for(let i=0; i<wrongAnswerArray.length;i++){
				
				let wrongAnswer = null;
				wrongAnswer = document.getElementsByClassName('status0')[i];
				wrongAnswer.addEventListener('click', choiceOnClick, false)
				wrongAnswer.myParam = wrongAnswer;
			}
			
			displayDeal.displayQuestionProposals();
			
		
		}
		request.open('GET', 'index.php?controller=QuizTryAjax&task=index&pid='+pid+'&tid='+tid+'&question='+question, true);
		request.responseType = 'json';
		request.send();
	}
	
	// ********************
	function nextOnClick(){
		
		
		question++
		
		//appel de la fonction displayNextQuestion qui gère l'affichage 
	    displayDeal.displayNextQuestion()
	    //appel de la fonction manageNextClick qui renvoit continued si il reste des questions
		let response = nextClickDeal.manageNextClick(question, point)
	
		if(response == 'continued'){
			
		   requete(question);
		}else if(document.getElementById('UserId')){
					
					let date = new Date();
					let options = {weekday: "long", year: "numeric", month: "long", day: "2-digit"};
					let ActualDate = date.toLocaleDateString("fr-FR", options);
					let Users_ID=document.getElementById('UserId').innerHTML;
					let Topics_ID = tid;
					let Score = point+" / "+totalQuestions.innerHTML;
					let QuizDate = ActualDate;
					let Valuation = response;
					
					let gameSummary = new GameSummary(Users_ID,Score,tid, QuizDate, Valuation)
					let jsonString = JSON.stringify(gameSummary);
					let xhr = new XMLHttpRequest;
					xhr.open('POST','index.php?controller=QuizReceive&task=index',true);
					xhr.setRequestHeader("Content-Type", "application/json");
					
					xhr.onreadystatechange = function() {//Call a function when the state changes.
					    if(xhr.readyState == 4 && xhr.status == 200) {
					       
					    }
					    
					}
					xhr.send(jsonString);
		}
		
	}
	 
	
	window.addEventListener("DOMContentLoaded", (event) => {
		
		// *************************écoute des evnts ***********************************
		
		// écoute du clique sur les bonnes réponses et appel de la fonction choiceOnClick
		if(correctAnswer != null && next != null){
		correctAnswer.addEventListener('click', choiceOnClick, false)
		correctAnswer.myParam = correctAnswer
		// écoute du clique sur les mauvaises réponses appel de la fonction choiceOnClick
		for(let i=0; i<wrongAnswerArray.length;i++){
						
			let wrongAnswer = null;
			wrongAnswer = wrongAnswerArray[i];
			wrongAnswer.myParam = wrongAnswer;
			wrongAnswer.addEventListener('click', choiceOnClick, false);
		
		}
		  
		// écoute du clique sur le bouton 'next' appel de la fonction nextOnClick
		next.addEventListener('click', nextOnClick );
		
		}
	})

}
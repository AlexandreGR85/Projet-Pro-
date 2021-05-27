class DisplayDeal{
    
    constructor(){
        
        this.point = 0;
        this.happySmiley = document.getElementById('happy_smiley');
        this.correctAnswerDisplay = document.getElementById('right');
        this.correctAnswerConfirmation = document.getElementById('correctAnswerConfirmation');
        this.sadSmiley = document.getElementById('sad_smiley');
        this.wrongAnswerDisplay = document.getElementById('wrong');
        this.correctAnswerCorrection = document.getElementById('correctAnswerCorrection');
        this.questionNum = document.getElementById('questionNum');
        this.QuestionResponses = document.getElementsByClassName('QuestionResponses')[0];
        this.nextButton = document.getElementById('next');
        this.sectionQuestion = document.getElementsByClassName('sectionQuestion')[0];
        this.sectionResult = document.getElementsByClassName('sectionResult')[0]
        this.articleResult = document.getElementsByClassName('articleResult')[0];
        this.image = document.getElementsByClassName('imagequestion')[1];
        this.switchResult = document.getElementById('switchResult');
        this.switchQuestion = document.getElementById('switchQuestion');
        
    }
    
    
    
    displayStatus(choiceStatus, correctAnswer){
        this.choiceStatus = choiceStatus;
        this.correctAnswer = correctAnswer;
        this.switchQuestion.classList.add('switchRightPosition')
        this.switchResult.classList.remove('hide')
        this.switchQuestion.classList.add('switchRightPosition');
        
        if(this.switchQuestion.classList.contains('hideTransitionReverse')){
            this.switchQuestion.style.transition = 'transform 0ms ease-in-out'
            this.switchQuestion.classList.remove('hideTransitionReverse')
        }
        
        if(this.switchResult.classList.contains('hideResult')){
            this.switchResult.style.transition = 'transform 0ms ease-in-out'
            this.switchResult.classList.remove('hideResult');
        }
  
        //Si le status vaut true, alors on incrément les points de 1 et on affiche le smiley et le message vrai  
        if(this.choiceStatus){
            this.point++;
            this.happySmiley.classList.remove('hide');
            this.correctAnswerDisplay.classList.remove('hide');
            this.correctAnswerConfirmation.classList.add('right')
            this.correctAnswerConfirmation.innerHTML= this.correctAnswer.innerHTML;
        //Sinon on affiche juste le smiley triste et le message faux
        }else{
        
        this.sadSmiley.classList.remove('hide');
        this.wrongAnswerDisplay.classList.remove('hide');
        this.correctAnswerCorrection.classList.add('wrong')
        this.correctAnswerCorrection.innerHTML= this.correctAnswer.innerHTML;
        }
    }

    displayNextQuestion(){
        
        this.switchQuestion.style.transition = 'transform 330ms ease-in-out'
        this.switchQuestion.classList.add('hideTransitionReverse')
        this.switchResult.style.transition = 'transform 330ms ease-in-out'
        this.switchResult.classList.add('hideResult');
        
        if(this.happySmiley.classList.contains('hide') ) {
	
        		this.sadSmiley.classList.add('hide')
        	}else(this.happySmiley.classList.add('hide'))
        	
        if(this.correctAnswerDisplay.classList.contains('hide')){
            this.wrongAnswerDisplay.classList.add('hide')
        }else(this.correctAnswerDisplay.classList.add('hide'))
        
    }
    
    
   displayQuestionProposals(){
       
   
        if(this.QuestionResponses.classList.contains('hide')){
        this.QuestionResponses.classList.remove('hide');
        }

   }    
    
}

export default DisplayDeal;
import DisplayDeal from './DisplayDeal.js';

class StatusCheck{
    
    
    constructor(correctAnswer, questionStatus){
        
        this.displayDeal = new DisplayDeal;
        this.correctAnswer = document.getElementsByClassName('status1')[0];
        this.questionStatus = questionStatus;
    }
    
    statusCheckManage(choiceStatus, correctAnswer){
        
        this.choiceStatus = choiceStatus;
        this.correctAnswer = correctAnswer;
        //Appel de la fonction displayStatus qui gère l'affichage en fonction du status de la réponse
        this.displayDeal.displayStatus(choiceStatus, correctAnswer)
    }
}

export default StatusCheck;
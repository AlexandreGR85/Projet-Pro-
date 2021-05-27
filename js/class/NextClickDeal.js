import DisplayDeal from './DisplayDeal.js';
import AppreciationsDeal from './AppreciationsDeal.js';


class NextClickDeal{
    
    constructor(next, newRequest, score){
  
        this.nextQuestion = next;
        this.newRequest = newRequest;
        this.score = score;
        
       
       
        this.pid = document.getElementById('pid').innerHTML;
        this.tid = document.getElementById('tid').innerHTML;
        this.totalQuestions = parseInt(document.getElementById('totalQuestions').innerHTML);
        
        this.pics = document.getElementById('pics');
        this.otherQuiz = document.getElementById('otherQuiz');
		this.manageNextClickBack = [];
		this.sectionQuestion = document.getElementsByClassName('sectionQuestion')[0];

        
        this.switchQuestion = document.getElementsByClassName('switchQuestion')[0];
        this.switchScore = document.getElementsByClassName('switchScore')[0];
		
		this.appreciation = document.getElementById("appreciation");
		this.goodAppreciationArray = ["est un très bon élément !", "doit continuer comme ça !", "ne changez rien !", "est a décidemment une tête bien faite !", "devrait être prof d'histoire !", ", quelle culture !"];
        this.averageAppreciationArray = ["est dans la moyenne.","a un niveau correct.","pourrait faire encore mieux.", "a un niveau passable.", "n'est ni un cancre, ni un cador.", "y arrive sans éclat."];
        this.badAppreciationArray = ["a un niveau médiocre...", "ne peut que s'améliorer...", "doit vraiment se réveiller...", "présente de graves lacunes en histoire...", "est surment meilleur en sport..."];
        this.goodCommentRandom = new AppreciationsDeal(this.goodAppreciationArray);
        this.averageCommentRandom = new AppreciationsDeal(this.averageAppreciationArray);
        this.badCommentRandom = new AppreciationsDeal(this.badAppreciationArray);
        
        this.appreciationText = document.getElementById("appreciationText");
        this.goodAppreciationTextArray = ["Bravo, vous êtes très fort !", "Continuez comme ça, vous êtes un champion !", "Ne changez rien, vous êtes parfait !", "Bravo, vous êtes décidément très fort", "Vous devriez être prof d'histoire !", "Bravo, quelle culture !"];
        this.averageAppreciationTextArray = ["Vous êtes dans la moyenne.","Vous avez un niveau correct.","Vous pourriez faire encore mieux.", "Vous avez un niveau passable.", "Vous n'etes ni un cancre, ni un cador.", "Votre niveau est moyen."];
        this.badAppreciationTextArray = ["Votre niveau est catastrophique...","Vous avez un niveau médiocre...", "Vous ne pouvez que vous améliorer...", "Vous devez vraiment vous réveiller...", "Vous présentez de graves lacunes en histoire...", "Vous êtes sûrment meilleur en sport...","Il va falloir travailler encore un peu..."];
        this.goodAppreciationRandom = new AppreciationsDeal(this.goodAppreciationTextArray);
        this.averageAppreciationRandom = new AppreciationsDeal(this.averageAppreciationTextArray);
        this.badAppreciationRandom = new AppreciationsDeal(this.badAppreciationTextArray);
        
        
		
		
		this.displayDeal = new  DisplayDeal;
		
		
    }
   
    manageNextClick(question, point){
        
        this.totalQuestions = parseInt(document.getElementById('totalQuestions').innerHTML);
        this.question = question;
        this.point = point;
        
        if( (parseInt(this.question)+1) <= this.totalQuestions){
            
		    return 'continued';
		    
            }else{ 
                
                this.switchQuestion.classList.add('hide');
                this.switchScore.classList.add('hideTransitionReverse');
                if(this.point>(this.totalQuestions/2)){
        		 	this.pics['src'] = "uploads/quizPics/cup.jpg";
        		 	this.score.innerHTML = "Votre score est de "+this.point+" / "+ this.totalQuestions;
        		 	this.appreciation.innerHTML = this.goodCommentRandom.rand()
        		 	this.appreciationText.innerHTML = this.goodAppreciationRandom.rand()
        		 		
        		 	}else if(this.point==(this.totalQuestions/2)){
        		 	    this.pics['src'] = "uploads/quizPics/graduate.jpg";
        		 		this.score.innerHTML = "Votre score est de "+this.point+" / "+this.totalQuestions+" ."
        		 		this.appreciation.innerHTML = this.averageCommentRandom.rand()
        		 		this.appreciationText.innerHTML = this.averageAppreciationRandom.rand()
        		 		
        		 	}else(	this.pics['src'] = "uploads/quizPics/donkey.jpg",
                		 	this.score.innerHTML = "Votre score est de "+this.point+" / "+this.totalQuestions+" .", this.appreciation.innerHTML = this.badCommentRandom.rand(), this.appreciationText.innerHTML = this.badAppreciationRandom.rand())
                		 	
                    
                    return this.appreciation.innerHTML;
                    }
    
    
    }

}

export default NextClickDeal;
<?php

namespace Controllers;

class QuizTryAjax extends Controller

{
    
  protected $modelName = \Models\Questions::class;
  protected $modelName2 = \Models\Response::class;
  
    
   public function index() {
        
        //controler que $_GET['id'] existe bien 
        if (isset($_GET['pid']) && ctype_digit($_GET['pid']) && isset($_GET['tid']) && ctype_digit($_GET['tid']) && isset($_GET['question']) && ctype_digit($_GET['question'])) {
                
               
                $questions = $this->model->findPeriodTopic(intval($_GET['pid']),intval($_GET['tid']));
                
                
                 
                $this->tplVars = $this->tplVars + ['totalOfQuestions' => $questions];
                
                
                //recupération d'un tableau des questions relatives au topic et à la periode
                $this->tplVars = $this->tplVars + ['questions' => $questions[$_GET['question']]];
               
                
                
                // // //récupération d'un tableau des tableau avec l'ensemble des lignes réponses (ID/Entitle/RightAnswer/Questions_ID)
                $this->tplVars = $this->tplVars + ['responses' => $this->model2->findQuestionId(intval($questions[$_GET['question']]['ID']))];
                
                $this->tplVars = $this->tplVars + ['questionNum' => $_GET['question']];
               
                
                echo json_encode($this->tplVars);
               
        
        }
        
    }
    
    
}
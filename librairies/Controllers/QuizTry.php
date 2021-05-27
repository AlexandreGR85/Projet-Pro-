<?php

namespace Controllers;

class QuizTry extends Controller

{
    
  protected $modelName = \Models\Questions::class;
  protected $modelName2 = \Models\Response::class;
  
    
   public function index() {
        
        //controler que $_GET['id'] existe bien 
        if (isset($_GET['pid']) && ctype_digit($_GET['pid']) && isset($_GET['tid']) && ctype_digit($_GET['tid'])&& isset($_GET['question']) && ctype_digit($_GET['question'])) {
                
                
              if(empty($questions = $this->model->findPeriodTopic(intval($_GET['pid']),intval($_GET['tid'])))){
                    
                    \Session::addFlash('error', 'Il n\'y a pas encore de Questions dans ce thème, revenez plus tard !');
                    \Http::redirectBack();
                   
                   
              }elseif((intval($_GET['question']))>(count($this->model->findPeriodTopic(intval($_GET['pid']),intval($_GET['tid']))))){
                   
                  \Session::addFlash('error', 'Une erreur est survenue, merci de réessayer ultérieurement.');
                    \Http::redirectBack();
              }
                
               
                $questions = $this->model->findPeriodTopic(intval($_GET['pid']),intval($_GET['tid']));
                //recupération d'un tableau des questions relatives au topic et à la periode
                $this->tplVars = $this->tplVars + ['questions' => $questions[$_GET['question']]];
               
                
                
                // // //récupération d'un tableau des tableau avec l'ensemble des lignes réponses (ID/Entitle/RightAnswer/Questions_ID)
                $this->tplVars = $this->tplVars + ['responses' => $this->model2->findQuestionId(intval($questions[0]['ID']))];
                
                
                $this->tplVars = $this->tplVars + ['questionNum' => $_GET['question']];
                
                //affichage
                
                \Renderer::show("quiz_try",$this->tplVars);
        
        }else{
            
            \Session::addFlash('error', 'Impossible d\'accéder à la page !');
            \Http::redirectBack();
            
        }
        
    }
    
    
}
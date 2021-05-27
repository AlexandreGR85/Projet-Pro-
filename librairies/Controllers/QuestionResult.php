<?php

namespace Controllers;

class QuestionResult extends Controller

{
    
  protected $modelName = \Models\Response::class;
    
   public function index() {
        
        //controler que $_GET['id'] existe bien 
        if (isset($_GET['qid']) && ctype_digit($_GET['qid']) && isset($_GET['tid']) && ctype_digit($_GET['tid'])) {
                
                
                $this->tplVars = $this->tplVars + ['questions' => $this->model->findTopicsAndId(intval($_GET['tid']),intval($_GET['qid']) )];
                
                
                $this->tplVars = $this->tplVars + ['responses' => $this->model->findQuestionAndAnswers(intval($_GET['qid']),intval($_GET['tid']))];
                
                
                //affichage
                \Renderer::show("quiz_try",$this->tplVars);
        
        }
    }
}
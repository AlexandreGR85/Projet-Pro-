<?php

namespace Controllers;

class AllQuizDone extends Controller

{
    
  protected $modelName = \Models\Games::class;
  protected $modelName2 = \Models\Topics::class;
  
    
   public function index() {
        
        if (isset($_GET['uid']) && ctype_digit($_GET['uid'])){
            
            $this->tplVars = $this->tplVars + ['quizDones' => $this->model->findUserId($_GET['uid'])];
            
            $this->tplVars = $this->tplVars + ['quizPeriods' => $this->model2->findAllPeriodsTopics()];

         \Renderer::show("quiz_done",$this->tplVars);
         
        }
        
    }
        
}

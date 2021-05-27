<?php

namespace Controllers;

class QuizShow extends Controller

{
    
  protected $modelName = \Models\Periods::class;
  protected $modelName2 = \Models\Topics::class;
    
   public function index() {
        
        
        if (isset($_GET['pid']) && ctype_digit($_GET['pid'])) {
                
                
                if(intval($_GET['pid']) > (count($this->model->findAll()))){
                    
                    
                    \Session::addFlash('error', 'Une erreur est survenue !');
                    \Http::redirectBack();
                }
        
                
                $period = $this->model->find(intval($_GET['pid']));
                
                

                $this->tplVars = $this->tplVars + [
                    'period_name' => $period['Name']
                ];
                
                $this->tplVars = $this->tplVars + ['topics' => $this->model2->findPeriodId(intval($_GET['pid']))];
                
                if(empty($this->tplVars['topics'])){
                    
                     \Session::addFlash('error', 'Il n\'y a pas encore de questions pour cette Période !');
                     \Http::redirectBack();
                    
                }
                
                //affichage
                \Renderer::show("quiz_show",$this->tplVars);
        
        }
    }
}
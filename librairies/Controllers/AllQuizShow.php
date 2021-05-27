<?php

namespace Controllers;

class AllQuizShow extends Controller

{
    
  protected $modelName = \Models\Topics::class;
    
   public function index() {
        
        
        $this->tplVars = $this->tplVars + ['TopicsAndPeriods' => $this->model->AllTopicsByPeriods()];
        
        \Renderer::show("all_quiz_show",$this->tplVars);
                
        }
        
   public function theme() {
        
        
        $this->tplVars = $this->tplVars + ['PeriodsAndTopics' => $this->model->AllTopicsByPeriods()];
        
        $this->tplVars = $this->tplVars + ["Topics" =>array_reverse($this->tplVars['PeriodsAndTopics'], false)];
        
        \Renderer::show("all_theme_show",$this->tplVars);
                
        }
 
}

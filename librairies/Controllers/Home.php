<?php

namespace Controllers;

class Home extends Controller 
{
   public function index() {
       
        //affichage
        \Renderer::show("home",$this->tplVars);
        
    }
    
    public function periods() {
        
        // $this->tplVars = $this->tplVars + ['periods' => $AllPeriods->findAll()];
        
        $this->tplVars = $this->tplVars + ["AllPeriods" =>array_reverse($this->tplVars['periods'], false)];
        
       
        //affichage
        \Renderer::show("all_periods_show",$this->tplVars);
        
    }
    
}
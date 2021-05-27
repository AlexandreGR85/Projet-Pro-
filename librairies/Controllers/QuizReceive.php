<?php

namespace Controllers;

class QuizReceive extends Controller 
{
    
    protected $modelName = \Models\Games::class;
   
    public function index() {
       
        $requestPayload = file_get_contents('php://input');
        $game = (json_decode($requestPayload, true));
        $this->model->insert($game);
    }
}




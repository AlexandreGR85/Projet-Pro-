<?php

namespace Controllers\Admin;

class ShowQuestions extends \Controllers\Admin 

{
    protected $pageCrud = "ShowQuestions";
    protected $pageTitle = "Gestion des Questions/Réponses";
    protected $pid = 0;
    protected $tid = 0;
    protected $modelName = \Models\Response::class;
    protected $modelName2 = \Models\Topics::class;
    protected $modelName3 = \Models\Periods::class;
    protected $modelName4 = \Models\Questions::class;
    
   public function index() {
        if (isset($_GET['pid']) && ctype_digit($_GET['pid']) && isset($_GET['tid']) && ctype_digit($_GET['tid'])) {
           
            $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
            
            
            $this->tplVars = $this->tplVars + ['PeriodTopics' => $this->model4->TopicsPeriodsByTopics(intval($_GET['tid']))];
            $this->tplVars = $this->tplVars + ['listsQuestions' => $this->model4->FindQuestionByPeriodsAndTopics(intval($_GET['pid']),intval($_GET['tid']))];
            $this->tplVars = $this->tplVars + ['listsResponses' =>  $this->model->FindAll()];
            $this->tplVars = $this->tplVars + ['listsQuestionsResponses' =>  $this->model->FindTopicsQuestionsResponses(intval($_GET['pid']),intval($_GET['tid']))];
      
      
            if(empty($this->tplVars['listsQuestionsResponses'])){
                
                \Renderer::showAdmin(strtolower($this->pageCrud)."/empty",$this->tplVars);
                die;
         
            }
             
            
             
             //afficher la liste 
            \Renderer::showAdmin(strtolower($this->pageCrud)."/display",$this->tplVars); 
        }
   }
   
   
   public function displayQuestions() {
        if (isset($_GET['pid']) && ctype_digit($_GET['pid']) && isset($_GET['tid']) && ctype_digit($_GET['tid'])) {


           
            $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
            
            
            $this->tplVars = $this->tplVars + ['PeriodTopics' => $this->model4->TopicsPeriodsByTopics(intval($_GET['tid']))];
            $this->tplVars = $this->tplVars + ['listsQuestions' => $this->model4->FindQuestionByPeriodsAndTopics(intval($_GET['pid']),intval($_GET['tid']))];
            $this->tplVars = $this->tplVars + ['listsResponses' =>  $this->model->FindAll()];
            $this->tplVars = $this->tplVars + ['listsQuestionsResponses' =>  $this->model->FindTopicsQuestionsResponses(intval($_GET['pid']),intval($_GET['tid']))];
       
            if (isset($_GET['modify'])){
                        
                        
                        \Renderer::showAdmin(strtolower($this->pageCrud)."/display-modify-questions",$this->tplVars);
                        
                        
                        die;
                    }
             
             //afficher la liste 
            \Renderer::showAdmin(strtolower($this->pageCrud)."/display-delete-questions",$this->tplVars); 
        }
   }
   

    
    
    public function update(array $data=[])
    {
        
        
        
        //tester les champs
        if (empty($_POST['id']) || empty($_POST['entitle']) || empty($_POST['pictures'])|| empty($_POST['pid'])|| empty($_POST['tid']))
       {
          //au moins un des 3 champs est vide
          \Session::addFlash('error', 'champ(s) obligatoire(s) non rempli(s) !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
        
    
       }
       
    
        //traiter le formulaire
        //preparation un tableau
        
        
         $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
        
       
        $data['Id'] =  intval($_POST['id']);
        $data['Entitle'] = $_POST['entitle'];
        $data['Pictures'] = $_POST['pictures'];
   
       
        //si on arrive ici on va pouvoir insérer notre nouveau rayon
      
       $modelName4->update($data);
       \Http::redirect(WWW_URL."index.php?controller=admin\\".$this->pageCrud."&task=index&pid=".$_POST['pid']."&tid=".$_POST['tid']);
        
    }
    
    public function updateAnswer(array $data=[])
    {
        
        
        
        //tester les champs
        if (empty($_POST['id'])||empty($_POST['proposal'])|| empty($_POST['rightAnswer'])|| empty($_POST['qid']))
       {
          //au moins un des 3 champs est vide
          \Session::addFlash('error', 'champ(s) obligatoire(s) non rempli(s) !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
        
    
       }
       
       if($_POST['rightAnswer']=='true'){
           
           $_POST['rightAnswer'] = 1;
       }else($_POST['rightAnswer']=0);
    
        //traiter le formulaire
        //preparation un tableau
        
        
         $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
        
       
        $data['Id'] =  intval($_POST['id']);
        $data['Proposal'] = $_POST['proposal'];
        $data['RightAnswer'] = $_POST['rightAnswer'];
        $data['Questions_ID'] = $_POST['qid'];
   
       
        //si on arrive ici on va pouvoir insérer notre nouveau rayon
       
       $this->model->update($data);
       \Http::redirect(WWW_URL."index.php?controller=admin\\".$this->pageCrud."&task=index&pid=".$_POST['pid']."&tid=".$_POST['tid']);
        
    }
    

    public function editFormQuestionResponse(){
        
        if (isset($_GET['qid']) && ctype_digit($_GET['qid']) && isset($_GET['rid']) && ctype_digit($_GET['rid'])) {
            
            
            
            
            $this->tplVars = $this->tplVars + ['form' => $this->model->FindQuestionResponse(intval($_GET['qid']),intval($_GET['rid']))];
            
            
            
            if($this->tplVars['form']['RightAnswer'] == 1){
                
                $this->tplVars['form']['RightAnswer'] = 'Réponse vraie';
                
            }else($this->tplVars['form']['RightAnswer'] = 'Réponse fausse');
           
           
            
             $this->tplVars = $this->tplVars + [
                    'periods' => $this->model->findAll()
                ];
           
            //titre de la page
            $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
                
            //afficher la liste des rayons
            \Renderer::showAdmin(strtolower($this->pageCrud)."/edit",$this->tplVars);
        
        
        } else {
            throw new \Exception('Impossible d\'afficher la page !');
        }
    
    }
    
    
    public function editFormQuestion(){
        
        if (isset($_GET['qid']) && ctype_digit($_GET['qid'])) {
            
            $this->tplVars = $this->tplVars + ['form' => $this->model4->Find(intval($_GET['qid']))];
  
            //titre de la page
            $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
                
            //afficher la liste des rayons
            \Renderer::showAdmin(strtolower($this->pageCrud)."/edit-question",$this->tplVars);
        
        
        } else {
            throw new \Exception('Impossible d\'afficher la page !');
        }
    
    }
    
    
     public function newForm(){
        //titre de la page
        $this->pageTitle = "Ajout d'une Question";
        $this->tid= $_GET['tid'];
        $this->pid= $_GET['pid'];
        parent::newForm();
    }
    
    
    
    public function create(array $data=[])
    {
        //tester les champs
       if (empty($_POST['entitle']) || empty($_POST['pid']) || empty($_POST['tid'])|| empty($_POST['img']))
       {
           //au moins un des 2 champs est vide
           \Session::addFlash('error', 'champ(s) obligatoire(s) non rempli(s) !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
       }
       
        $pidint = intval($_POST['pid']);
        $tidint = intval($_POST['tid']);
       
        //preparation un tableau
        $data['Entitle'] = $_POST['entitle'];
        $data['Pictures'] = $_POST['img'];
        $data['Periods_ID'] =$pidint;
        $data['Topics_ID'] = $tidint;
        //si on arrive ici on va pouvoir insérer 
        
        $this->model4->insert($data);
        
        $this->tplVars = $this->tplVars + ['new' =>$this->model4->findQuestionIdByEntitle($data['Entitle'])];
        $this->tplVars = $this->tplVars + ['newQuestionEntitle' => $data['Entitle']];
        $this->tplVars = $this->tplVars + ['newQuestionPid' => $data['Periods_ID']];
        $this->tplVars = $this->tplVars + ['newQuestionTid' => $data['Topics_ID']];
        
      
        $this->pageTitle = "Ajout des réponses";
        $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
        
        
         \Renderer::showAdmin(strtolower($this->pageCrud)."/add-responses",$this->tplVars);
    }
    
    
    public function createResponses(array $response1 = [], array $response2 = [], array $response3 = [], array $response4 = [] )
    {
        //tester les champs
       if (empty($_POST['response1']) || empty($_POST['response2']) || empty($_POST['response3']) || empty($_POST['response4']) ||  empty($_POST['qid']) ||empty($_POST['correctAnswer']) || empty($_POST['pid']) || empty($_POST['tid']) )
       {
           //au moins un des 2 champs est vide
           \Session::addFlash('error', 'champ(s) obligatoire(s) non rempli(s) !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
       }
       
       
       $true = 1;
       $false = 0;
       
       if($_POST['correctAnswer'] == 'response1'){
           
           $response1['RightAnswer'] = $true;
       }else($response1['RightAnswer'] = $false);
       
       
       if($_POST['correctAnswer'] == 'response2'){
           $response2['RightAnswer'] = $true;
       }else($response2['RightAnswer'] = $false);
       
       
       if($_POST['correctAnswer'] == 'response3'){
           $response3['RightAnswer'] = $true;
       }else($response3['RightAnswer'] = $false);
       
       
       if($_POST['correctAnswer'] == 'response4'){
           $response4['RightAnswer'] = $true;
       }else($response4['RightAnswer'] = $false);
       
        $pidint = intval($_POST['pid']);
        $tidint = intval($_POST['tid']);
        $qidint = intval($_POST['qid']);
       
        //preparation un tableau
        $response1['Proposal'] = $_POST['response1'];
        $response1['Questions_ID'] =  $qidint;
        $response2['Proposal'] = $_POST['response2'];
        $response2['Questions_ID'] = $_POST['qid'];
        $response3['Proposal'] = $_POST['response3'];
        $response3['Questions_ID'] = $_POST['qid'];
        $response4['Proposal'] = $_POST['response4'];
        $response4['Questions_ID'] = $_POST['qid'];
        
    
        //si on arrive ici on va pouvoir insérer 
        
        
        $this->model->insert($response1);
        $this->model->insert($response2);
        $this->model->insert($response3);
        $this->model->insert($response4);
       
        
        
         \Http::redirect(WWW_URL."index.php?controller=admin\\".$this->pageCrud."&task=index&pid=".$pidint."&tid=".$tidint);
    }
    
    
    
    public function delete() 
    {
            
            //controler que $_GET['id'] existe bien 
        if (isset($_GET['id']) && ctype_digit($_GET['id']) && isset($_GET['pid']) && ctype_digit($_GET['pid']) && isset($_GET['tid']) && ctype_digit($_GET['tid'])) {
       
            $this->model->delete(intval($_GET['id']));
            
            //si fichier dans uploads, on le supprime
            if (file_exists("uploads/".strtolower($this->pageCrud)."/".intval($_GET['id']).".gif"))
            {
                unlink("uploads/".strtolower($this->pageCrud)."/".intval($_GET['id']).".gif");
            }
            
            \Session::addFlash('success','Suppression réussie !');
            
            \Http::redirect(WWW_URL."index.php?controller=admin\\".$this->pageCrud."&task=index&pid=".$_GET['pid']."&tid=".$_GET['tid']);
        
        
        }
        else {
            throw new \Exception('Impossible de supprimer !');
        }
            
    }
    
    public function deleteQuestion() 
    {
            
            //controler que $_GET['id'] existe bien 
        if (isset($_GET['id']) && ctype_digit($_GET['id']) && isset($_GET['pid']) && ctype_digit($_GET['pid']) && isset($_GET['tid']) && ctype_digit($_GET['tid'])) {
            
            
             $this->tplVars = $this->tplVars + ['answersToDelete' =>  $this->model->FindResponses($_GET['id'])];
   
            
        foreach($this->tplVars['answersToDelete'] as $answerToDelete ){
   
            $this->model->delete(intval($answerToDelete['ID']));
        }

           
            $this->model4->delete(intval($_GET['id']));
            

            \Session::addFlash('success','Suppression réussie !');
            
            \Http::redirect(WWW_URL."index.php?controller=admin\\".$this->pageCrud."&task=index&pid=".$_GET['pid']."&tid=".$_GET['tid']);
        
        
        }
        else {
            throw new \Exception('Impossible de supprimer !');
        }
            
    }
    
}
    
    
    

    
    
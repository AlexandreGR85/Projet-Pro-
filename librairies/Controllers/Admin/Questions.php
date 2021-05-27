<?php

namespace Controllers\Admin;

class Questions extends \Controllers\Admin {
    
    protected $pageCrud = "QuestionsResponses";
    protected $pageTitle = "Gestion des Questions";
    protected $modelName = \Models\Response::class;
    protected $modelName2 = \Models\Periods::class;
    protected $modelName3 = \Models\Topics::class;
    
    public function index() {
           
            $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
            
            
            $this->tplVars = $this->tplVars + ['listsPeriods' => $this->model2->findAll()];
            $this->tplVars = $this->tplVars + ['listsTopics' => $this->model3->AllTopicsByPeriods()];
          
             //afficher la liste 
            \Renderer::showAdmin(strtolower($this->pageCrud)."/display",$this->tplVars); 
          }
    
    
    
    public function update(array $data=[]){
        //tester les champs
        if (empty($_POST['entitle']) || empty($_POST['id']) || empty($_POST['img']) || empty($_POST['periods_name']))
       {
           //au moins un des 4 champs est vide
           \Session::addFlash('error', 'champ(s) obligatoire(s) non rempli(s) !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
       }
        
         $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
        
        
        $period_id = [];
        
        $period_id = $period_id +[ 'id' =>$this->model2->findPeriodIdByName($_POST['periods_name'])
        ];
      
         $period_id_int = (intval($period_id['id']['ID']));
        
        
        $data['Entitle'] = $_POST['entitle'];
        $data['Img'] = $_POST['img'];
        $data['Periods_ID'] = $period_id_int;
        $data['Id'] = intval($_POST['id']);
        //si on arrive ici on va pouvoir insérer notre nouveau rayon
       
        
        parent::update($data);
        
    }
    
    
    public function editFormPeriodName(){
            //controler que $_GET['id'] existe bien 
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            
            //transmettre à $this->tplVars ces informations
            
            $this->tplVars = $this->tplVars + [
                    'form' => $this->model->TopicsPeriodsByTopics(intval($_GET['id']))
                ];
                
                
            //Ensemble des Noms et ID des Périodes
            
            $this->tplVars = $this->tplVars + [
                    'periods' => $this->model->findAll()
                ];
    
            //titre de la page
            $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
                
            //afficher la liste des rayons
            \Renderer::showAdmin(strtolower($this->pageCrud)."/edit",$this->tplVars);
        
        }
        else {
            throw new \Exception('Impossible d\'afficher la page !');
        }
  
    }
    
     public function newForm(){
        //titre de la page
        $this->pageTitle = "Ajout d'un Thème";
        
        parent::newForm();
    }
    
    public function create(array $data=[]){
        //tester les champs
       if (empty($_POST['entitle']) || empty($_POST['img']) || empty($_POST['periods_name'])){
           //au moins un des 2 champs est vide
           \Session::addFlash('error', 'champ(s) obligatoire(s) non rempli(s) !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
       }
        
        $period_id = [];
        
        $period_id = $period_id +[ 'id' =>$this->model2->findPeriodIdByName($_POST['periods_name'])
        ];
        
        // $period_id_int = intval($period_id);
        
         $period_id_int = (intval($period_id['id']['ID']));
        //traiter le formulaire
        //preparation un tableau
        $data['Entitle'] = $_POST['entitle'];
        $data['Img'] = $_POST['img'];
        $data['Periods_ID'] = $period_id_int;
        //si on arrive ici on va pouvoir insérer 
        parent::create($data);
    }
    
}
    
    
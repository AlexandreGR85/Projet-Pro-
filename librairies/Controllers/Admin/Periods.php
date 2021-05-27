<?php

namespace Controllers\Admin;

class Periods extends \Controllers\Admin 

{
    protected $pageCrud = "Periods";
    protected $pageTitle = "Gestion des Périodes";
    protected $modelName = \Models\Periods::class;
    
   public function index() {
           
            $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
        
        
            //recupération du nom de la période
            $this->tplVars = $this->tplVars + ['lists' => $this->model->findAll()];
             
            //afficher la liste 
            \Renderer::showAdmin(strtolower($this->pageCrud)."/display",$this->tplVars);
        
    }

    public function update(array $data=[]){
        //tester les champs
        if (empty($_POST['name']) || empty($_POST['id']) || empty($_POST['img']) || empty($_POST['description']))
       {
           //au moins un des 3 champs est vide
           \Session::addFlash('error', 'champ(s) obligatoire(s) non rempli(s) !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
       }
        
        //traiter le formulaire
        //preparation un tableau
        
        $data['Name'] = $_POST['name'];
        $data['Img'] = $_POST['img'];
        $data['Description'] = $_POST['description'];
        $data['Id'] = intval($_POST['id']);
        
        //si on arrive ici on va pouvoir insérer notre nouveau rayon
        parent::update($data);
        
    }
    
    public function newForm() {
        //titre de la page
        $this->pageTitle = "Ajout d'une Période";
        
        parent::newForm();
    }
    
    public function create(array $data=[]){
        //tester les champs
       if (empty($_POST['name']) || empty($_POST['img']) || empty($_POST['description'])){
           //au moins un des 2 champs est vide
           \Session::addFlash('error', 'champ(s) obligatoire(s) non rempli(s) !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
       }
        
        //traiter le formulaire
        //preparation un tableau
        $data['Name'] = $_POST['name'];
        $data['Img'] = $_POST['img'];
        $data['Description'] = $_POST['description'];
        //si on arrive ici on va pouvoir insérer 
        parent::create($data);
    }
}
    
    
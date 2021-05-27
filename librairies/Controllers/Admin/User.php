<?php

namespace Controllers\Admin;

class User extends \Controllers\Admin
{
   protected $modelName = \Models\User::class;
   
   protected $pageCrud = "User";
   
   protected $pageTitle = "Gestion des comptes";
   
   public function index() {
           
           
           
           
           //titre de la page
            $this->tplVars = $this->tplVars + [
                'page_title' => $this->pageTitle
            ];
            
            //liste des données
            $this->tplVars = $this->tplVars + [
                'lists' => $this->model->findAll()
            ];
                
            
            foreach($this->tplVars['lists'] as $list){
                
                if($list["Admin"] == null){
                    
                    $list["Admin"] = "Non";
                    
                }else($list["Admin"] = "Oui");
            }
            
            
            
            //afficher la liste 
            \Renderer::showAdmin(strtolower($this->pageCrud)."/display",$this->tplVars);

        
    }
    
    
    public function update(array $data=[])
    {
        //tester les champs
        if (empty($_POST['id']) ||empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || (empty($_POST['admin']) && empty($_POST['notadmin'])))
       {
           //au moins un des 3 champs est vide
           \Session::addFlash('error', 'champ(s) obligatoire(s) non rempli(s) !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
       }
        
        
        if(!empty($_POST['admin']) && !empty($_POST['notadmin'])){
            
            \Session::addFlash('error', 'L\'utilisateur ne peut pas être à la fois administrateur et non administrateur !');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
        }
        
        if(!empty($_POST['admin'])){
            
            $_POST['admin'] = 1;
        }else( $_POST['admin'] = null);
        //traiter le formulaire
        //preparation un tableau
        
        $data['Id'] = intval($_POST['id']);
        $data['FirstName'] = $_POST['firstname'];
        $data['LastName'] = $_POST['lastname'];
        $data['Email'] = $_POST['email'];
        $data['admin'] = $_POST['admin'];
        
        
       
        //si on arrive ici on va pouvoir insérer notre nouveau rayon
        parent::update($data);
        
    }
    
}
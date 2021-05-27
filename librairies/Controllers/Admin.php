<?php

namespace Controllers;

class Admin extends Controller 
{
    protected $pageCrud; //nom du crud
    
    protected $pageTitle; //titre de la page
    
    public function __construct()
    {
        //tester si l'utilisateur est bien admin
        \Session::redirectIfNotAdmin();
        
        //appel du constructeur du parent
        parent::__construct();
        
        //envoyer le nom du crud dans le template
        $this->tplVars = $this->tplVars + [
                'crud' => $this->pageCrud
            ];
        
    }
    
    public function index() {
           
           
            
           $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
        
        
            //recupération du nom de la période
            $this->tplVars = $this->tplVars + ['lists' => $this->model->findAll()];
             
                
            //afficher la liste 
            \Renderer::showAdmin(strtolower($this->pageCrud)."/display",$this->tplVars);

        
    }
    
    public function newForm() 
    {
           //titre de la page
            $this->tplVars = $this->tplVars + [
                    'page_title' => $this->pageTitle
                ];
                
                
            if(isset($this->pid)){
                
            
                if($this->pid>0 && $this->pid>0){
                    
                    $this->tplVars = $this->tplVars + [
                        'pid' => $this->pid
                    ];
                    
                    $this->tplVars = $this->tplVars + [
                        'tid' => $this->tid
                    ];
                }
                
                
            }
            
           
                
            //afficher la liste des rayons
            \Renderer::showAdmin(strtolower($this->pageCrud)."/add",$this->tplVars);

        
    }
    
    public function create(array $data)
    {
        //si on arrive ici on va pouvoir insérer 
        if ($this->model->insert($data) >0)
        {
            //le compte a bien été créé
            \Session::addFlash('success','Création réussie !');
            
            \Http::redirect(WWW_URL."index.php?controller=admin\\".$this->pageCrud."&task=index");
        }
        else {
            //l'insertion a échouée
            \Session::addFlash('error','l\'insertion a échouée !');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
    }
    
    
    public function editForm() 
    {
            //controler que $_GET['id'] existe bien 
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            
            //transmettre à $this->tplVars ces informations
            
            $this->tplVars = $this->tplVars + [
                    'form' => $this->model->find(intval($_GET['id']))
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
    
    public function update(array $data)
    {
      
        //si on arrive ici on va pouvoir insérer notre nouveau rayon
        $this->model->update($data);
        \Http::redirect(WWW_URL."index.php?controller=admin\\".$this->pageCrud."&task=index");
        
    }
    
    public function delete() 
    {
            
            //controler que $_GET['id'] existe bien 
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            
            $this->model->delete(intval($_GET['id']));
            
            //si fichier dans uploads, on le supprime
            if (file_exists("uploads/".strtolower($this->pageCrud)."/".intval($_GET['id']).".gif"))
            {
                unlink("uploads/".strtolower($this->pageCrud)."/".intval($_GET['id']).".gif");
            }
            
            \Session::addFlash('success','Suppression réussie !');
            
            \Http::redirect(WWW_URL."index.php?controller=admin\\".$this->pageCrud."&task=index");
        
        
        }
        else {
            throw new \Exception('Impossible de supprimer !');
        }
            
    }
    
}
<?php

namespace Controllers;


abstract class Controller
{
   
    protected $model;
    
    protected $model2;

    protected $modelName;
    
    protected $modelName2;
    
    protected $modelName3;
    
    protected $modelName4;
    
    protected $tplVars = []; //un tableau qui contiendra toutes les valeurs par default à transmettre au template
  
    /**
     * Le constructeur a pour seul but de vérifier la validité du model demandé et de créer un objet issu de la classe demandée
     */
    public function __construct()
    {

    // 1. Vérifier que le développeur a bien renseigné le nom d'un model
    if (!empty($this->modelName)) {
            // 2. Vérifier si le model existe
            $chemin = str_replace("\\", "/", "librairies/{$this->modelName}.php");
            // Si $this->modelName contient "User", ça donne "libraries/Models/User.php"
            if (!file_exists($chemin)) {
                // Si le fichier n'existe pas, on fait une nouvelle erreur
                throw new \Exception("Le model défini dans " . get_called_class() . " ({$this->modelName}) n'existe pas ! Nous n'avons pas trouvé le fichier qui aurait du se trouver ici : $chemin !");
            }

        $this->model = new $this->modelName();
        
        if(!empty($this->modelName2)){
        
            $this->model2 = new $this->modelName2();
        }
        
        if(!empty($this->modelName3)){
        
            $this->model3 = new $this->modelName3();
        }
        
        if(!empty($this->modelName4)){
        
            $this->model4 = new $this->modelName4();
        }
        
    }
    
        
        /*
        initialisation des données par default
        */
        
            
        $AllPeriods = new \Models\Periods();
        $AllTopics= new \Models\Topics();
        
        $this->tplVars = $this->tplVars + ['periods' => $AllPeriods->findAll()];
        $this->tplVars = $this->tplVars + ['menuTopics' => $AllTopics->findAll()];
        $this->tplVars = $this->tplVars + ['WWW_URL' => WWW_URL];
        
    }

}

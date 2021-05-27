<?php

class Application {
    
    //méthode static permettant de créer l'instance du controller demandé et appel de la méthode principale
    public static function process() {
        
        //valeurs par default
        $controllerName = "Home";
        $task = "index";
        
        if (!empty($_GET["controller"])) {
            //récupération d'un nom de controller en GET
            $controllerName = htmlspecialchars(ucfirst($_GET["controller"]));
            
        }
        
        if (!empty($_GET["task"])) {
            //récupération d'un nom de méthode en GET
            $task = htmlspecialchars($_GET["task"]);
            
        }
        
        //construction du nom du controller
        //ex \Controllers\Product
        //   \namespace\Nom_De_La_Class
        $controllerName = "\Controllers\\".$controllerName;
        
        //création de l'instance
        
        //$controller = new \Controllers\Product();
        $controller = new $controllerName();
        
        //$controller contient l'instance de l'objet
        
        
        //appel de la méthode
        $controller->$task();
    }
}
<?php
/* class traitant le rendu html de la page en fonction du contenu dynamique et du template */

class Renderer {
    
    /**
     * La fonction show() permet d'afficher un template avec le header et le footer qui l'accompagnent.
     *
     * @param string $template Le chemin vers le fichier .phtml sans l'extension
     * @param array $variables Le tableau associatif contenant les variables utilisées dans le template PHTML
     * @return void
     */
    public static function show(string $template, array $tplVars = [])
    {
        ob_start();
        
        require("librairies/templates/partials/$template.phtml");
        $pageContent = ob_get_clean();
        
        require('librairies/templates/layout.phtml');

    }
    
     
    public static function showAjax(string $template, array $tplVars = [])
    {
    
    require("librairies/templates/partials/$template.phtml");
    
    }
    
    /**
     * La fonction showAdmin() permet d'afficher un template Admin avec le header et le footer qui l'accompagnent.
     *
     * @param string $template Le chemin vers le fichier .phtml sans l'extension
     * @param array $variables Le tableau associatif contenant les variables utilisées dans le template PHTML
     * @return void
     */
    public static function showAdmin(string $template, array $tplVars = [])
    {
        ob_start();
        
        require("librairies/templates/partials/admin/$template.phtml");
        $pageContent = ob_get_clean();
        
        require('librairies/templates/layoutAdmin.phtml');

    }
    
    /**
     * La fonction showError() permet d'afficher une exception
     *
     * @param array $variables Le tableau associatif contenant les variables utilisées dans le template PHTML
     * @return void
     */
    public static function showError(array $tplVars = [])
    {

        require("librairies/templates/partials/error.phtml");

    }
    
    
}
<?php

namespace Controllers;

class User extends Controller 
{
   //contruction du nom du modele à utiliser
   protected $modelName = \Models\User::class;
   
   public function loginForm() 
   {
      $myToken = new \Token();
        
      $this->tplVars = $this->tplVars + ['Token' => $myToken->encode(SECRETKEY)];
        
        
        echo json_encode($this->tplVars);
        //affichage
         
   }
   
   //méthode de deconnection
   public function out() {
       \Session::disconnect();
       
       \Http::redirect(WWW_URL);
       
   }
   
   public function login() {
       //est-ce que j'ai les champs email et password
       if (empty($_POST['email'])  || 
       empty($_POST['token']) ||
       empty($_POST['password']))
       {
           //au moins un des 2 champs est vide
           \Session::addFlash('error', 'champs obligatoires non remplis !');
            //rediriger l'utilisateur vers le formulaire de login
            \Http::redirectBack();
       }
       
       //tester le token
        $myToken = new \Token();
        
        if (!SECRETKEY == $myToken->decode($_POST['token']))
        {
            \Session::addFlash('error', 'le token a expiré !');
            
            //détruire le token
            \Session::deleteToken();
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //détruire le token
        \Session::deleteToken();
       
       //tester si le couple email/password existe bien
       if (!$this->model->verifEmailPwd($_POST['email'], $_POST['password']))
       {
          //identification impossible
           \Session::addFlash('error', 'identification impossible !');
            //rediriger l'utilisateur vers le formulaire de login
            \Http::redirectBack();
       }
       
       //l'identification a réussi
       
       //si l'utilisateur est Admin on le redirige vers le dashboard
       //sinon vers l'accueil du site
       if (\Session::isAdmin()) {
          \Http::redirect(WWW_URL."index.php?controller=Admin\Dashboard&task=index"); 
       }
       
       \Http::redirect(WWW_URL);
   }
   
   public function index() 
   {
        //création du token
        $myToken = new \Token();
        
        $this->tplVars = $this->tplVars + ['Token' => $myToken->encode(SECRETKEY)];
        
        
        //affichage
        \Renderer::show("newUser",$this->tplVars);
        
    }
    
    public function create() 
    {
        
        
        //quels controle on doit faire avant de lancer une insertion dans la base ?
        
        //vérifier la présence des champs obligatoire
          
        if (empty($_POST['firstname']) ||
          empty($_POST['lastname']) ||
          empty($_POST['email']) ||
          empty($_POST['password']) ||
          empty($_POST['password2'])) 
          
        {
            //au moins un des champs obligatoires non rempli
            \Session::addFlash('error', 'au moins un des champs obligatoires non rempli !');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //tester le token
        $myToken = new \Token();
        
        if (!SECRETKEY == $myToken->decode($_POST['token']))
        {
            \Session::addFlash('error', 'le token a expiré !');
            
            //détruire le token
            \Session::deleteToken();
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //détruire le token
        \Session::deleteToken();
        
        
        //test firstname et lastname non numérique
        if (ctype_digit($_POST['firstname']) || ctype_digit($_POST['lastname']))
        {
            //au moins le nom ou le prénom est numérique
            \Session::addFlash('error', 'nom et prénom ne peuvent pas être numérique !');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //vérifier le format de l'email
        //utiliser filter_var('bob@example.com', FILTER_VALIDATE_EMAIL)
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            //l'email n'est pas au bon format
            \Session::addFlash('error', 'l\'email n\'est pas au bon format !');
            //rediriger l'utilisateur vers le formulaire
           \Http::redirectBack();
        }
        
        //s'assurer que les 2 valeurs de mot de passe sont identiques
        if ($_POST['password'] !== $_POST['password2'])
        {
            //les 2 mots de passe ne sont pas identiques
            \Session::addFlash('error','les 2 mots de passe ne sont pas identiques !');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //bonus : verifier que le mot de passe est complexe

        
        if(
            preg_match("#[A-Z]#", $_POST['password']) 
            + preg_match("#[a-z]#", $_POST['password']) 
            + preg_match("#[0-9]#", $_POST['password']) != 3)
        {
         //mot de passe pas assez complexe
          \Session::addFlash('error','mot de passe pas assez complexe !');
          //rediriger l'utilisateur vers le formulaire
          \Http::redirectBack();
        }
        
        
        //besoin d'une requete SQL vérifier si l'email existe déjà dans la base de données
        //"SELECT Id FROM Users WHERE Email LIKE monemail@gmail.com"
        
        if($this->model->is_exist_user($_POST['email']))
        {
            //l'email est déjà présent
            \Session::addFlash('error','l\'email existe déjà !');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //si on arrive ici on va pouvoir insérer notre nouvel utilisateur
        if ($this->model->create($_POST))
        {
            //le compte a bien été créé
            \Session::addFlash('success','Votre compte a été créé, vous pouvez vous connecter !');
            
            
            //rediriger l'utilisateur vers la page d'accueil
            \Http::redirect(WWW_URL);
        }
        else {
            //l'insertion a échouée
            \Session::addFlash('error','la création du compte a échouée !');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        
        
    }
}
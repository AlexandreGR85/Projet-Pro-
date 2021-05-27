<?php

namespace Models;

class User extends Model
{
    //pour utiliser Model, on doit définir une propriété protected $table
    //qui contient le nom de la table principale
    protected $table = T_USERS;
    
    //récupération specifique de champ de la table Users
    /*
    Id, Admin, FirstName et LastName
    */
    public function findAll_Id_Admin_Fn_Ln(): array
    {
        $query = $this->db->prepare("SELECT Id, LastName, FirstName, Admin FROM $this->table");
        
        $query->execute();
        

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    //renvoie le rôle d'un utilisateur
    public function getRole(int $id): int
    {
       $query = $this->db->prepare("SELECT Admin FROM $this->table WHERE Id = :id");
        
        $query->execute([
            ':id' => $id,
        ]);
        
        $infosUser = $query->fetch(\PDO::FETCH_ASSOC);
        
        return intval($infosUser['Admin']);
    }
    
    //renvoie les coordonnées de l'utilisateur
    public function getAddress(int $id): array
    {
       $query = $this->db->prepare("SELECT LastName, FirstName FROM $this->table WHERE Id = :id");
        
        $query->execute([
            ':id' => $id,
        ]);
        
        return $query->fetch(\PDO::FETCH_ASSOC); 
    }
    
    
    
    //tester si un email est déjà présent dans la table Users
    public function is_exist_user(string $email)
    {
        $query = $this->db->prepare("SELECT Id FROM $this->table WHERE Email LIKE :email");
        $query->execute([
            ':email' => $email,
        ]);

        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
    //méthode pour vérifier le mot de passe
    private function verifPassword($pass, $pass_hash) {
    //vérifier le mot de passe
    //https://www.php.net/manual/fr/function.openssl-decrypt


        if ($pass === openssl_decrypt($pass_hash, "AES-128-ECB", SECRETKEY)) {
            return true;
        }
        
        return false;

    }
    
    //crypt mot de passe
    private function cryptPassword($pass) {
        //hasher le mot de passe
        //https://www.php.net/manual/fr/function.openssl-encrypt
        
        return openssl_encrypt($pass, "AES-128-ECB", SECRETKEY);
    }
    
    //création d'un user
    public function create(array $u):bool
    {
        
        //trouver avec phpmyadmin la bonne requete à mettre en place
        //de type insert
        
        //préparer les différents champs de la table user
        /* 
        construire un tableau qui va contenir en clé les noms des champs 
        et en valeur, la valeur a insérer
        */
        $insertUser = [];
        
        $insertUser['FirstName'] = $u['firstname'];
        $insertUser['LastName'] = $u['lastname'];
        $insertUser['Email'] = $u['email'];
        $insertUser['Password'] = $this->cryptPassword($u['password']); //crypter le mot de passe
        
        
        //utiliser la méthode insert du model
        if ($this->insert($insertUser) >0) {
            //l'insertion a fonctionné
            return true;
        }
        else {
            //on a eu une erreur
            return false;
        }
    }
    
    public function verifEmailPwd(string $email,string $pwd):bool
    {
        //récupérer l'enregistrement qui correspond au mail
        $query = $this->db->prepare("SELECT ID,FirstName,Password,Admin FROM $this->table WHERE Email LIKE :email LIMIT 0,1");
        $query->execute([
            ':email' => $email,
        ]);

        //stockage du résultat dans une variable de travail
        $myUser = $query->fetch(\PDO::FETCH_ASSOC);
        
        if (!$myUser) {
            //la requete n'a rien donné, on met fin au programme, en renvoyant false
            return false;
        }
        
        //ici on a bien un email reconnu
        //il faut quand même tester le mot de passe
        if (!$this->verifPassword($pwd, $myUser['Password']))
        {
            //mauvais mot de passe;
            return false;
        }
        
        // //mettre à jour la date de Last_login
        // $sql = "UPDATE $this->table SET Last_login = NOW() WHERE Id= :Id";
        
        // $query = $this->db->prepare($sql);

        // $query->execute(['Id'=> $myUser['Id']]);
        
        //création d'un session utilisateur
        \Session::connect([
            'Id' => intval($myUser['ID']),
            'FirstName' => htmlspecialchars($myUser['FirstName']),
            'Admin' => intval($myUser['Admin'])
            ]);
        
        //identification réussi
        return true;
        
    }
}

?>
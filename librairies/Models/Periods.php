<?php

namespace Models;

class Periods extends Model
{
    //pour utiliser Model, on doit définir une propriété protected $table
    //qui contient le nom de la table principale
    protected $table = T_PERIODS;
    
    
    
     public function deletePeriod(int $id)
    {
        $query = $this->db->prepare("DELETE FROM ".T_PERIODS." WHERE Id = :id");

        $query->execute(['id' => $id]);
    }
}

?>
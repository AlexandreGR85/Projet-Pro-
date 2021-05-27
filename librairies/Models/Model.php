<?php

namespace Models;



/**

 * LES PROPRIETES :
 * -----------------
 * - $db est un objet de la classe PDO qui représente la connexion à la base de données
 * - $table  est une chaine de caractère qui indique au model à quelle table il s'intéresse !
 *
 * LES METHODES :
 * -----------------
 * - findAll() : selection de toutes les lignes de la table
 * - find($id) : selection d'une seule ligne via l'identifiant
 * 
 * - findPeriodId($pid) : selection des lignes en fonction de la période
 * - findPeriodIdByName($name): permet de retrouver l'id de la période lorsque l'on a son nom
 * - findPeriodTopic($pid, $tid): selections des lignes en fonction du sujet et de la période
 * - findQuestionId($qid): selection des lignes en fonction de la question
 * - findQuestionAndAnswers(int $qid, int $tid): selections des lignes en fonction de la question et du sujet
 * - findUserId(int $uid): retrouve la ligne en fonction de l'id de l'utilisateur
 * - AllTopicsByPeriods(): retrouve tout les sujets liés à une période
 * - AllTopicsByPeriods(): sélectionne toutes les topics en y rattachant le nom des périodes
 * - FindQuestionByPeriodsAndTopics(int $pid, int $tid): retrouve la question en fonction de la periode et du sujet
 * - FindResponses($qid): retrouve les réponse en fonction de la question
 * - findQuestionIdByEntitle(string $entitle): retrouve la question en fonction de son intitulé
 * 
 * - insert($array) : insertion d'une nouvelle ligne dans la table
 * - update($array) : mise à jour d'une ligne dans la table
 * - delete($id) : suppression d'une ligne dans la table grâce à son identifiant
 */
abstract class Model
{
    
    protected $db;

    protected $table;

    /**
     * Constructeur qui vérifie que la table est bien précisée
     * et qui met en place la connexion à la base de données
     */
    public function __construct(){
        // 1. On vérifie que le nom de la table est bien précisé
        if (empty($this->table)) {
            // Si le développeur a zappé cette étape, on la lui rappelle avec une bonne grosse erreur !
            throw new \Exception('Vous devez absolument spécifier une propriété <em>protected $table</em> dans votre classe ' . get_called_class() . ' qui hérite de Model et qui contient le nom de la table à attaquer.');
        }

        // 2. Si tout est bon, on créé l'objet PDO en utilisant les données du fichier de configuration
       $this->db =\Database::getInstance();
        //$this->db = getInstance();
    }

    public function findAll(): array{
       
        $query = $this->db->prepare("
        SELECT * 
        FROM $this->table
        ");
        
        $query->execute();
        

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function find(int $id){
        
        $query = $this->db->prepare("
        SELECT * 
        FROM $this->table 
        WHERE ID = :id");
        $query->execute([
            ':id' => $id,
        ]);

        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
     public function findPeriodId(int $pid){
        $query = $this->db->prepare("
        SELECT * 
        FROM $this->table 
        WHERE Periods_ID = :pid"
        );
        $query->execute([
            ':pid' => $pid,
        ]);

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function findPeriodIdByName(string $name){
        
        $query = $this->db->prepare("
        SELECT ID 
        FROM $this->table 
        WHERE Name = :name
        ");
        $query->execute([
            ':name' => $name,
        ]);

        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
     public function findPeriodTopic(int $pid,int $tid){
        
        $query = $this->db->prepare("
        SELECT * 
        FROM $this->table 
        WHERE Periods_ID= :pid AND Topics_ID = :tid");
        $query->execute([
            ':pid' => $pid,
            ':tid' => $tid,
        ]);

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
     public function findQuestionId(int $qid){
       
        $query = $this->db->prepare("
        SELECT * 
        FROM $this->table 
        WHERE Questions_ID = :qid"
        );
        $query->execute([
            ':qid' => $qid,
        ]);

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function findQuestionAndAnswers(int $qid, int $tid){
        $query = $this->db->prepare("
            SELECT answers.Questions_ID, answers.ID, answers.Proposal, answers.RightAnswer
            FROM $this->table
            INNER JOIN questions ON questions.ID = answers.Questions_ID
            WHERE questions.ID = :qid AND questions.Topics_ID= :tid
        ");
        $query->execute([
            ':qid' => $qid,
            ':tid' => $tid,
        ]);
         return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    public function findUserId(int $uid){
       
        $query = $this->db->prepare("
            SELECT games.ID, QuizDate, Valuation, Topics_ID, topics.Img, Users_ID, Score, Entitle
            FROM $this->table
            INNER JOIN topics ON topics.ID = games.Topics_ID
            WHERE Users_ID = :uid
        ");
        $query->execute([
            ':uid' => $uid,
        ]);

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    public function findAllPeriodsTopics(): array{
       
        $query = $this->db->prepare("
            SELECT topics.ID, periods.Name, periods.ID AS 'pid'
            FROM $this->table
            INNER JOIN periods ON periods.ID = topics.Periods_ID
        ");
        
        $query->execute();
        

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    

    /**
     * Permet de récupérer la liste des données
     *
     * @return array
     */
    
    
    
    public function AllTopicsByPeriods(): array{
        $query = $this->db->prepare("
        SELECT topics.Periods_ID, periods.Name, Entitle, topics.img, topics.ID 
        FROM $this->table 
        JOIN periods ON periods.id = topics.Periods_ID"
        );
        $query->execute();
        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    

    public function TopicsPeriodsByTopics($id): array{
        $query = $this->db->prepare("
        SELECT topics.Periods_ID AS 'pid', periods.Name, Entitle, topics.img, topics.ID AS 'tid'
        FROM topics JOIN periods ON periods.id = topics.Periods_ID 
        WHERE topics.ID = :id"
        );
        $query->execute([
            ':id' => $id,
        ]);
    
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
    
    public function FindTopicsQuestionsResponses(int $pid, int $tid): array{
        $query = $this->db->prepare("
        SELECT answers.ID,answers.Questions_ID, questions.Topics_ID, questions.Periods_ID , answers.RightAnswer ,answers.Proposal, questions.Entitle
        FROM $this->table
        INNER JOIN questions ON questions.ID = answers.Questions_ID 
        WHERE questions.ID = :pid AND answers.ID=  :tid"
        );
        $query->execute([
            ':pid' => $pid,
            ':tid' => $tid
        ]);
    
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function FindQuestionPeriodTopic(): array{
        $query = $this->db->prepare("
        SELECT periods.Name, topics.Entitle AS TopicsName, questions.ID, questions.Entitle
        FROM $this->table
        INNER JOIN periods ON periods.ID = questions.Periods_ID
        INNER JOIN topics ON topics.ID = questions.Topics_ID"
        );
        $query->execute();
    
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    
    
    public function FindQuestionByPeriodsAndTopics(int $pid, int $tid): array{
        $query = $this->db->prepare("
        SELECT * 
        FROM $this->table 
        WHERE Periods_ID = :pid AND Topics_ID= :tid");
        $query->execute([
            ':pid' => $pid,
            ':tid' => $tid
        ]);
    
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    
    public function FindResponses($qid): array{
        $query = $this->db->prepare("
        SELECT * 
        FROM $this->table 
        WHERE Questions_ID= :qid ");
        $query->execute([
            ':qid' => $qid,
        ] );
    
        return $query->fetchAll(\PDO::FETCH_ASSOC);
        
    }
    
    public function FindQuestionResponse(int $qid, int $rid): array{
        $query = $this->db->prepare("
        SELECT answers.ID,answers.Questions_ID, questions.Topics_ID, questions.Periods_ID , answers.RightAnswer ,answers.Proposal, questions.Entitle
        FROM $this->table
        INNER JOIN answers ON answers.Questions_ID = questions.ID
        WHERE questions.ID = :qid AND answers.ID= :rid 
            ");
        $query->execute([
            ':qid' => $qid,
            ':rid' => $rid
        ] );
    
        return $query->fetch(\PDO::FETCH_ASSOC);
        
    }
    
    
    
    public function findQuestionIdByEntitle(string $entitle): array{
        $query = $this->db->prepare("
        SELECT ID 
        FROM $this->table 
        WHERE Entitle = :entitle");
        $query->execute([
            ':entitle' => $entitle,
        ]);

        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
    
    
    
    /**
     * Permet d'insérer un nouvel enregistrement et retourne l'identifiant
     *
     * @param array $data
     * @return integer
     */
    public function insert(array $data): int{
        $sql = "INSERT INTO $this->table SET ";

        $columns = array_keys($data);
        $sqlColumns = [];

        foreach ($columns as $column) {
            $sqlColumns[] = "$column = :$column";
        }

        $sql .= implode(",", $sqlColumns);

        $query = $this->db->prepare($sql);

        $query->execute($data);

        return $this->db->lastInsertId();
    }

    /**
     * Permet de mettre à jour un enregistrement
     *
     * @param array $data
     * @return void
     */
    public function update(array $data){
        if (!array_key_exists('Id', $data)) {
            throw new Exception("Vous ne pouvez pas appeler la fonction update sans préciser dans votre tableau un champ `id` !");
        }

        $sql = "UPDATE $this->table SET ";

        $columns = array_keys($data);
        $sqlColumns = [];

        foreach ($columns as $column) {
            if ($column != 'Id') {
            $sqlColumns[] = "$column = :$column";
            }
        }

        $sql .= implode(",", $sqlColumns);

        $sql .= " WHERE Id = :Id";

        $query = $this->db->prepare($sql);
        
        $query->execute($data);
    }

    /**
     * Permet de supprimer un enregistrement
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id){
        $query = $this->db->prepare("DELETE FROM $this->table WHERE Id = :id");

        $query->execute(['id' => $id]);
    }
}
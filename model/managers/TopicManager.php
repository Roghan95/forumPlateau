<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager
{

    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct()
    {
        parent::connect();
    }


    public function findTopicsByCategorie($id)
    {
        $sql = "SELECT t.id_topic, t.titre, COUNT(t.id_topic) AS nbPosts
        FROM categorie c
        INNER JOIN topic t ON t.categorie_id = c.id_categorie
        INNER JOIN post p ON p.topic_id = t.id_topic
        WHERE c.id_categorie = :id 
        GROUP BY t.id_topic";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }
}

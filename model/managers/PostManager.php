<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager
{

    protected $className = "Model\Entities\Post";
    protected $tableName = "post";


    public function __construct()
    {
        parent::connect();
    }


    public function findPostsByTopic($id)
    {
        $sql = "SELECT * FROM " . $this->tableName . " p
            WHERE p.topic_id = :id";
            
        $sql2 = "SELECT COUNT(t.id_topic) AS nbPosts
            FROM categorie c
            INNER JOIN topic t ON t.categorie_id = c.id_categorie
            INNER JOIN post p ON p.topic_id = t.id_topic
            WHERE c.id_categorie = :id 
            GROUP BY t.id_topic";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            DAO::select($sql2, ['id' => $id]),
            $this->className
        );
    }


    // public function nbPosts($id)
    // {
    //     $sql = "SELECT t.id_topic, COUNT(*) AS nbPosts
    //     FROM post p
    //     INNER JOIN topic t ON p.topic_id = t.id_topic
    //     WHERE t.id_topic =:id";

    //     return $this->getMultipleResults(
    //         DAO::select($sql, ['id' => $id]),
    //         $this->className
    //     );
    // }
}

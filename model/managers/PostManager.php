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
        // Requete SQL qui permet de récupérer les posts d'un topic
        $sql = "SELECT * FROM " . $this->tableName . " p
            WHERE p.topic_id = :id";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function findPostsByUser($id)
    {
        // Requete SQL qui permet de récupérer les posts d'un utilisateur
        $sql = "SELECT * FROM " . $this->tableName . " p
            WHERE p.user_id = :id";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function findLastPostByTopic($id)
    {
        // Requete SQL qui permet de récupérer le dernier post d'un topic
        $sql = "SELECT * FROM " . $this->tableName . " p
            WHERE p.topic_id = :id
            ORDER BY p.dateCreation DESC
            LIMIT 1";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function findNbPostsByTopic($id)
    {
        // Requete SQL qui permet de compter le nombre de posts par topic
        $sql = "SELECT COUNT(*) AS nbPosts FROM " . $this->tableName . " p
            WHERE p.topic_id = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function findNbPostsByUser($id)
    {
        // Requête SQL qui compte le nombre de posts d'un utilisateur
        $sql = "SELECT COUNT(*) AS nbPosts FROM " . $this->tableName . " p
            WHERE p.user_id = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }
}

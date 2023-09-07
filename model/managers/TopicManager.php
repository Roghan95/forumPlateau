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
        $sql = "SELECT t.id_topic, t.titre, t.locked, t.dateCreation, t.user_id, t.categorie_id, 
        COUNT(t.id_topic) AS nbPosts
        FROM categorie c
        INNER JOIN topic t ON t.categorie_id = c.id_categorie
        LEFT JOIN post p ON p.topic_id = t.id_topic
        WHERE c.id_categorie = :id 
        GROUP BY t.id_topic";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function updateTopic($id, $titre)
    {
        $sql = "UPDATE topic
        SET titre = :titre
        WHERE id_topic = :id";

        return DAO::update($sql, ['id' => $id, 'titre' => $titre]);
    }
}


















    // public function findTopicsByUser($id)
    // {
    //     $sql = "SELECT t.id_topic, t.titre, t.locked, t.dateCreation, t.user_id, t.categorie_id, 
    //     COUNT(t.id_topic) AS nbPosts
    //     FROM user u
    //     INNER JOIN topic t ON t.user_id = u.id_user
    //     LEFT JOIN post p ON p.topic_id = t.id_topic
    //     WHERE u.id_user = :id 
    //     GROUP BY t.id_topic";

    //     return $this->getMultipleResults(
    //         DAO::select($sql, ['id' => $id]),
    //         $this->className
    //     );
    // }

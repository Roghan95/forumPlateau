<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\CategorieManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface
{


    public function index()
    {
        $topicManager = new TopicManager();
        //    var_dump($topicManager->findAll(["dateCreation", "DESC"]));
        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "topics" => $topicManager->findAll(["dateCreation", "DESC"])
            ]
        ];
    }

    public function listCategories()
    {
        $categorieManager = new CategorieManager();
        // var_dump($categorieManager->findAll(["nomCategorie", "DESC"])->current());die; 
        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categorieManager->findAll(["nomCategorie", "DESC"])
            ]
        ];
    }

    public function listTopicsByCategorie($id)
    {

        $topicManager = new TopicManager();
        $categorieManager = new CategorieManager();

        return [
            "view" => VIEW_DIR . "forum/TopicsByCategorie.php",
            "data" => [
                "topics" => $topicManager->findTopicsByCategorie($id, ["dateCreation", "DESC"]),
                "categories" => $categorieManager->findOneById($id)
            ]
        ];
    }

    public function listPostsByTopic($id)
    {
        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $categorieManager = new CategorieManager();

        return [
            "view" => VIEW_DIR . "forum/PostsByTopics.php",
            "data" => [
                "posts" => $postManager->findPostsByTopic($id, ["dateCreation", "DESC"]),
                "categories" => $categorieManager->findOneById($id),
                "topics" => $topicManager->findOneById($id)
            ]
        ];
    }

}

<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Entities\Categorie;
    use Model\Entities\Post;
    use Model\Entities\Topic;
    use Model\Entities\User;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategorieManager;
    use Model\Managers\UserManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          
           $topicManager = new TopicManager();
        //    var_dump($topicManager->findAll(["dateCreation", "DESC"]));
            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["dateCreation", "DESC"])
                ]
            ];
        }

        public function listCategories(){
            
           $categorieManager = new CategorieManager();
            // var_dump($categorieManager->findAll(["nomCategorie", "DESC"])->current());die; 
            return [
                "view" => VIEW_DIR."forum/listCategories.php",
                "data" => [
                    "categories" => $categorieManager->findAll(["nomCategorie", "DESC"])
                ]
            ];
        }

        // public function findPostsByTopic() {
        //     $detailCategorie = new Categorie();
        //     return [
        //         "view" => VIEW_DIR."forum/listCategories.php",
        //         "data" => [
        //             "categories" => $detailCategorie->findOneById(["id", "DESC"])
        //         ]
        //     ];
        // }

        
    }

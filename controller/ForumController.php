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

    // La fonction index permet d'afficher les topics et de les trier par date de création
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

    // La fonction listCategories permet d'afficher les catégories
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

    // La fonction listTopicsByCategorie permet d'afficher les topics d'une catégorie par son id
    public function listTopicsByCategorie($id)
    {
        $postManager = new PostManager();
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

    // La fonction listPostsByTopic permet d'afficher les posts d'un topic par son id
    public function listPostsByTopic($id)
    {
        // var_dump($id);
        // die;
        // On instancie les managers des posts, topics et catégories
        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $categorieManager = new CategorieManager();

        // On retourne la vue et les données suivantes
        return [
            "view" => VIEW_DIR . "forum/PostsByTopics.php",
            "data" => [
                "posts" => $postManager->findPostsByTopic($id, ["dateCreation", "DESC"]),
                "topic" => $topicManager->findOneById($id)
            ]
        ];
    }

    // Ajouter une catégorie
    public function addCategorie()
    {
        // Si on clique sur le bouton "Ajouter une catégorie"
        if (isset($_POST["addCategorie"])) {
            // On récupère le nom de la catégorie et on le filtre
            $nomCategorie = filter_input(INPUT_POST, 'nomCategorie', FILTER_SANITIZE_SPECIAL_CHARS);
            // On instancie le manager des catégories
            $categorieManager = new CategorieManager();

            $data = [
                // On récupère le nom de la catégorie
                "nomCategorie" => $nomCategorie
            ];
            // On ajoute la catégorie
            $categorieManager->add($data);
            // On redirige vers la liste des catégories
            $this->redirectTo("forum", "listCategories");
        }
    }

    // Supprimer une catégorie
    public function deleteCategorie($id)
    {
        if (isset($_POST["deleteCategorie"])) {
            // On instancie le manager des catégories
            $categorieManager = new CategorieManager();

            // On supprime la catégorie par son id
            $categorieManager->delete($id);
            // On redirige vers la liste des catégories
            $this->redirectTo("forum", "listCategories");
        }
    }

    // Ajouter un post
    public function addPost($id)
    {
        // Si on clique sur le bouton "Ajouter un post" alors on récupère le texte du post et on le filtre
        if (isset($_POST["addPost"])) {
            // On récupère le texte du post et on le filtre
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_SPECIAL_CHARS);
            $postManager = new PostManager();

            // On ajoute le post selon les données suivantes (texte, user_id, topic_id). Le user_id est fixé à 2 car on n'a pas encore de système de connexion
            $data = [
                "texte" => $texte,
                "user_id" => 4,
                "topic_id" => $id
            ];
            // var_dump($data);
            // die;
            // On ajoute le post et on redirige vers la liste des posts du topic par son id
            $postManager->add($data);
            $this->redirectTo("forum", "listPostsByTopic", $id);
        }
    }

    // Supprimer un post
    public function deletePost($id)
    {
        if (isset($_POST["deletePost"])) {
            // On instancie le manager des posts
            $postManager = new PostManager();
            // On supprime le post par son id
            $postManager->delete($id);
            // On redirige vers la liste des posts du topic par son id
            $this->redirectTo("forum", "listPostsByTopic", $id);
        }
    }

    // Ajouter un topic
    public function addTopic($id)
    {
        // Si on clique sur le bouton "Ajouter un topic" alors on récupère le titre du topic et on le filtre
        if (isset($_POST["addTopic"])) {
            // On récupère le titre du topic et on le filtre
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
            $topicManager = new TopicManager();
            // var_dump($topicManager);
            // var_dump($titre);
            // On ajoute le topic selon les données suivantes (titre, user_id, categorie_id). Le user_id est fixé à 2 car on n'a pas encore de système de connexion
            $data = [
                "titre" => $titre,
                "user_id" => 4,
                "categorie_id" => $id
            ];
            // var_dump($data);
            // die;
            // On ajoute le topic et on redirige vers la liste des topics de la catégorie par son id
            $topicManager->add($data);
            $this->redirectTo("forum", "listTopicsByCategorie", $id);
        }
    }

    // Supprimer un topic
    public function deleteTopic($id)
    {
        // On instancie le manager des topics
        $topicManager = new TopicManager();
        // On récupère le topic par son id
        $topic = $topicManager->findOneById($id);
        // // var_dump($topic);
        // // die;
        $idCategorie = $topic->getCategorie()->getId();
        // // On supprime le topic par son id
        $topicManager->delete($id);
        // var_dump($id);
        // die;
        $this->redirectTo("forum", "listTopicsByCategorie", $idCategorie);
    }

    // Modifier un topic
    public function updateTopic($id)
    {
        // Si on clique sur le bouton "Modifier un topic" alors on récupère le titre du topic et on le filtre
        if (isset($_POST["updateTopic"])) {
            // On récupère le titre du topic et on le filtre
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
            $topicManager = new TopicManager();

            // On modifie le topic selon les données suivantes (titre, user_id, categorie_id). Le user_id est fixé à 2 car on n'a pas encore de système de connexion
            $data = [
                "titre" => $titre,
            ];
            // On modifie le topic et on redirige vers la liste des topics de la catégorie par son id
            $topicManager->update($id, $data);
            $this->redirectTo("forum", "listTopicsByCategorie", $id);
        }
    }
}

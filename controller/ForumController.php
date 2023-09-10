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
        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $categorieManager = new CategorieManager();

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
        // On instancie le manager des catégories
        $categorieManager = new CategorieManager();

        // On supprime la catégorie par son id
        $categorieManager->delete($id);
        // On redirige vers la liste des catégories
        $this->redirectTo("forum", "listCategories");
    }
    // Modifier une catégorie
    public function updateCategorie($id)
    {
        if (isset($_POST["updateCategorie"]) && isset($_POST["nomCategorie"]) && !empty($_POST["nomCategorie"])) {
            $nomCategorie = filter_input(INPUT_POST, 'nomCategorie', FILTER_SANITIZE_SPECIAL_CHARS);
            if ($nomCategorie) {
                $categorieManager = new CategorieManager();
                $categorieManager->updateCategorie($id, $nomCategorie);
                $this->redirectTo("forum", "listCategories");
            }
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
                "user_id" => $_SESSION["user"]->getId(),
                "topic_id" => $id
            ];
            // var_dump($data);
            // die;
            $postManager->add($data);
            $this->redirectTo("forum", "listPostsByTopic", $id);
        }
    }

    // Méthode pour suppimer un post sauf si c'est le premier post du topic avec findFirstPostByTopic()
    public function deletePost($id)
    {

        // On instancie les managers
        $postManager = new PostManager();

        // On récupère l'id du topic du post
        $post = $postManager->findOneById($id);
        $idTopic = $post->getTopic()->getId();

        // On récupère l'id du premier post du topic
        $firstPost = $postManager->findFirstPostByTopic($idTopic);

        $idFirstPost = $firstPost->getId();
        // Si l'id du post est différent de l'id du premier post du topic, on supprime le post
        if ($id != $idFirstPost) {
            $postManager->delete($id);
        }
        // On redirige vers la page du topic
        $this->redirectTo("forum", "listPostsByTopic", $idTopic);
    }

    // Modifier un post
    public function updatePostForm($id)
    {
        $postManager = new PostManager();
        $topicId = $postManager->findOneById($id)->getTopic()->getId();
        if (isset($_POST["updatePost"]) && isset($_POST["texte"]) && !empty($_POST["texte"])) {
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_SPECIAL_CHARS);
            if ($texte) {
                $postManager->updatePostAction($id, $texte);
                $this->redirectTo("forum", "listPostsByTopic", $topicId);
            }
        }
    }

    // Ajouter un topic
    public function addTopic($id)
    {
        if (
            isset($_POST["addTopic"]) && isset($_POST['titre']) && !empty($_POST['titre'])
            && isset($_POST['texte']) && !empty($_POST['texte'])
        ) {
            // On récupère les différents champs du formulaire pour les filtrer
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_SPECIAL_CHARS);
            $topicManager = new TopicManager();
            $postManager = new PostManager();
            $data = [
                "titre" => $titre,
                "user_id" => $_SESSION["user"]->getId(),
                "categorie_id" => $id
            ];

            $topicId = $topicManager->add($data);

            $data2 = [
                "texte" => $texte,
                "user_id" => $_SESSION["user"]->getId(),
                "topic_id" => $topicId
            ];
            $postManager->add($data2);
            $this->redirectTo("forum", "listPostsByTopic", $topicId);
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
        $topicManager = new TopicManager();
        $categorieId = $topicManager->findOneById($id)->getCategorie()->getId();
        if (isset($_POST["updateTopic"]) && isset($_POST["titre"]) && !empty($_POST["titre"])) {
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
            if ($titre) {
                $topicManager->updateTopic($id, $titre);
                $this->redirectTo("forum", "listTopicsByCategorie", $categorieId);
            }
        }
    }

    // Méthode pour vérouiller un topic
    public function lockTopic($id)
    {
        $topicManager = new TopicManager();
        $topicManager->lockTopic($id);
        $this->redirectTo("forum", "listPostsByTopic", $id);
    }

    // Méthode pour dévérouiller un topic
    public function unlockTopic($id)
    {
        $topicManager = new TopicManager();
        $topicManager->unlockTopic($id);
        $this->redirectTo("forum", "listPostsByTopic", $id);
    }
}

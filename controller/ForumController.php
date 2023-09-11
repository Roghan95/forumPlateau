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
        if (isset($_POST["addCategorie"]) && (Session::isAdmin())) {

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
        } else {
            Session::addFlash("error", "Vérifiez que vous êtes bien connectés !");
        }
        $this->redirectTo("forum", "listCategories");
    }

    // Supprimer une catégorie
    public function deleteCategorie($id)
    {
        if ((Session::isAdmin())) {
            // On instancie le manager des catégories
            $categorieManager = new CategorieManager();
            // On supprime la catégorie par son id
            $categorieManager->delete($id);
            // On redirige vers la liste des catégories
        } else {
            Session::addFlash("error", "Vous n'avez pas les droits pour cet action!");
        }
        $this->redirectTo("forum", "listCategories");
    }

    // Modifier une catégorie
    public function updateCategorie($id)
    {
        if (isset($_POST["updateCategorie"]) && isset($_POST["nomCategorie"]) && !empty($_POST["nomCategorie"]) && (Session::isAdmin())) {
            $nomCategorie = filter_input(INPUT_POST, 'nomCategorie', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($nomCategorie) {
                $categorieManager = new CategorieManager();
                $categorieManager->updateCategorie($id, $nomCategorie);
                $this->redirectTo("forum", "listCategories");
            }
        } else {
            Session::addFlash("error", "Vous n'avez pas les droits pour cet action!");
        }
    }

    // Ajouter un post
    public function addPost($id)
    {
        // Si on clique sur le bouton "Ajouter un post" alors on récupère le texte du post et on le filtre, ensuite on vérifie si l'utilisateur est connecté ou qu'il est admin
        $postManager = new PostManager();
        if (isset($_POST["addPost"]) && isset($_SESSION["user"])) {
            // On récupère le texte du post et on le filtre
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On ajoute le post selon les données suivantes (texte, user_id, topic_id). Le user_id est fixé à 2 car on n'a pas encore de système de connexion
            $data = [
                "texte" => $texte,
                "user_id" => $_SESSION["user"]->getId(),
                "topic_id" => $id
            ];
            $postManager->add($data);
        } else {
            Session::addFlash("error", "Vous devez être connectés pour faire cet action!");
        }

        if ($postManager) {
            Session::addFlash("success", "Merci d'avoir répondu !");
        } else {
            Session::addFlash("error", "Une erreur est survenue, veuillez réessayer.");
        }
        $this->redirectTo("forum", "listPostsByTopic", $id);
    }

    // Méthode pour suppimer un post sauf si c'est le premier post du topic avec findFirstPostByTopic()
    public function deletePost($id)
    {
        // On instancie les managers
        $postManager = new PostManager();

        // On récupère l'id du topic du post
        $post = $postManager->findOneById($id);
        $idTopic = $post->getTopic()->getId();

        // On vérifie si l'utilisateur est admin ou l'auteur du post pour supprimer le post
        if ((Session::isAdmin()) || ($_SESSION["user"]) && $_SESSION["user"]->getId() == $post->getUser()->getId()) {

            // On récupère l'id du premier post du topic
            $firstPost = $postManager->findFirstPostByTopic($idTopic);

            $idFirstPost = $firstPost->getId();
            // Si l'id du post est différent de l'id du premier post du topic, on supprime le post
            if ($id != $idFirstPost) {
                $postManager->delete($id);
            }
        } else {
            Session::addFlash("error", "Vous devez être connectés pour faire cet action!");
        }

        if ($id != $idFirstPost) {
            Session::addFlash("success", "Message supprimé avec succès");
        } else {
            Session::addFlash("error", "Vous ne pouvez pas supprimé le premier message de ce topic");
        }

        // On redirige vers la page du topic
        $this->redirectTo("forum", "listPostsByTopic", $idTopic);
    }

    // Modifier un post
    public function updatePostForm($id)
    {

        $postManager = new PostManager(); // On instancie le manager des posts

        $topicId = $postManager->findOneById($id)->getTopic()->getId(); // On récupère l'id du topic du post
        if (isset($_POST["updatePost"]) && isset($_POST["texte"]) && !empty($_POST["texte"]) && (Session::isAdmin()) || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topicId->getUser()->getId())) {
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_SPECIAL_CHARS); // On récupère le champ texte du form et on le filtre
            if ($texte) {
                $postManager->updatePostAction($id, $texte);
                Session::addFlash("success", "Message modifié avec succès.");
            } else {
                Session::addFlash("error", "Une erreur est survenue, veuillez réessayer");
            }
        }
        $this->redirectTo("forum", "listPostsByTopic", $topicId);
    }

    // Ajouter un topic
    public function addTopic($id)
    {
        $topicManager = new TopicManager();
        $postManager = new PostManager();

        if (
            // Vérification des champs du form 
            isset($_POST["addTopic"]) && isset($_POST['titre']) && !empty($_POST['titre'])
            && isset($_POST['texte']) && !empty($_POST['texte']
                // partie Session
                && (isset($_SESSION["user"]) && $_SESSION["user"]->getId($id)))
        ) {
            // On récupère les différents champs du formulaire pour les filtrer
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_SPECIAL_CHARS);
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
        }
        $this->redirectTo("forum", "listPostsByTopic", $topicId);
    }

    // Supprimer un topic
    public function deleteTopic($id)
    {
        // On instancie le manager topic
        $topicManager = new TopicManager();

        $topic = $topicManager->findOneById($id);
        $idCategorie = $topic->getCategorie()->getId();
        if (Session::isAdmin() || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topicManager->findOneById($id)->getUser()->getId())) {

            // // On supprime le topic par son id
            $topicManager->delete($id);
            Session::addFlash("success", "Topic supprimé"); // Message d'erreur
        } else {
            Session::addFlash("error", "Vous n'avez pas les droits pour cet action!"); // Message d'erreur
        }
        $this->redirectTo("forum", "listTopicsByCategorie", $idCategorie); // Redirection
    }

    // Modifier un topic
    public function updateTopic($id)
    {
        $topicManager = new TopicManager(); // On instancie le mananger
        $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS); // On filtre le champ "titre" du form

        $categorieId = $topicManager->findOneById($id)->getCategorie()->getId(); // On récupère l'id de la catégorie du topic

        if (isset($_POST["updateTopic"]) && Session::isAdmin() || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topicManager->findOneById($id)->getUser()->getId())) {
            if ($titre) {
                $topicManager->updateTopic($id, $titre);
                Session::addFlash("success", "Le titre du topic modifié avec succès.");
            } else {
                Session::addFlash("error", "Vous n'avez pas les droits pour cet action!");
            }
        }
        $this->redirectTo("forum", "listPostsByTopic", $categorieId);
    }

    // Méthode pour vérouiller un topic
    public function lockTopic($id)
    {
        if (Session::isAdmin()) {
            $topicManager = new TopicManager();
            $topicManager->lockTopic($id);
            Session::addFlash("success", "Topic verrouillé");
        } else {
            Session::addFlash("error", "Vous n'avez pas les droits pour cet action!");
        }
        $this->redirectTo("forum", "listPostsByTopic", $id);
    }

    // Méthode pour dévérouiller un topic
    public function unlockTopic($id)
    {
        if (Session::isAdmin()) {
            $topicManager = new TopicManager();
            $topicManager->unlockTopic($id);

            Session::addFlash("sucess", "Topic déverrouillé"); // Message de succès
        } else {
            Session::addFlash("error", "Vous n'avez pas les droits pour cet action!"); // Message d'erreur
        }
        $this->redirectTo("forum", "listPostsByTopic", $id);
    }
}

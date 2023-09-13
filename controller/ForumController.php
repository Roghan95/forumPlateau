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
    }

    // La fonction listCategories permet d'afficher les catégories
    public function listCategories()
    {
        $categorieManager = new CategorieManager(); // On instancie le manager des catégories
        $topicManager = new TopicManager(); // On instancie le manager des topics
        $allTopics = $topicManager->findAll(); // On récupère tous les topics
        $TotalTopics = 0; // On initialise le compteur x à 0
        foreach ($allTopics as $topic) {
            $TotalTopics += 1; // On incrémente x de 1 à chaque tour de boucle
        }

        $ids = $categorieManager->findAll(["dateCreation", "DESC"]); // On récupère tooutes les catégories
        $tabId = []; // On initialise un tableau vide qui va stocker le nombre de topics de chaque catégorie
        foreach ($ids as $categorie) { // On boucle sur les catégories

            $id = $categorie->getId(); // On récupère l'id de la catégorie
            $topics = $topicManager->findTopicsByCategorie($id, ["dateCreation", "DESC"]); // On récupère les topics de la catégorie
            $y = 0; // On initialise le compteur y à 0

            if ($topics != null) { // Si la catégorie contient des topics
                foreach ($topics as $topic) { // On compte les topics de la catégorie
                    $y += 1; // On incrémente y de 1 à chaque tour de boucle
                }
            } else { // Si la catégorie ne contient pas de topics
                $y = 0; // On initialise y à 0
            }
            array_push($tabId, $y); // On ajoute le nombre de topics de la catégorie dans le tableau tabId
        }
        return [
            "view" => VIEW_DIR . "forum/listCategories.php", // On retourne la vue listCategories.php
            "data" => [
                "categories" => $categorieManager->findAll(["dateCreation", "DESC"]), // On retourne toutes les catégories
                "tabId" => $tabId, // On retourne le tableau tabId
                "allTopics" => $TotalTopics // On retourne le nombre total de topics
            ]
        ];
    }

    // La fonction listTopicsByCategorie permet d'afficher les topics d'une catégorie par son id
    public function listTopicsByCategorie($id)
    {
        $topicManager = new TopicManager();
        $categorieManager = new CategorieManager();

        $topics = $topicManager->findTopicsByCategorie($id, ["dateCreation", "DESC"]);
        if ($topics) {
            return [
                "view" => VIEW_DIR . "forum/TopicsByCategorie.php",
                "data" => [
                    "topics" => $topics,
                    "categories" => $categorieManager->findOneById($id)
                ]
            ];
        } else {
            $this->redirectTo("forum", "listCategories");
        }
    }

    // La fonction listPostsByTopic permet d'afficher les posts d'un topic par son id
    public function listPostsByTopic($id)
    {
        $postManager = new PostManager();
        $topicManager = new TopicManager();

        $posts = $postManager->findPostsByTopic($id, ["dateCreation", "DESC"]);
        if ($posts) {
            return [
                "view" => VIEW_DIR . "forum/PostsByTopics.php",
                "data" => [
                    "posts" => $posts,
                    "topic" => $topicManager->findOneById($id)
                ]
            ];
        }
        $this->redirectTo("forum", "listCategories");
    }

    // Ajouter une catégorie
    public function addCategorie()
    {
        // On vérifie que l'utilisateur est connecté et est admin
        if (!Session::isAdmin()) {
            // On enregistre un message flash
            Session::addFlash("error", "Vous devez être connecté en tant qu'administrateur pour créer une catégorie");
            // On redirige vers la page de connexion
            $this->redirectTo("security", "login");
        }

        // On instancie les managers
        $categorieManager = new CategorieManager();
        if ($categorieManager) {

            // On récupère le nom de la catégorie
            $nomCategorie = filter_input(INPUT_POST, 'nomCategorie', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On ajoute la catégorie
            $categorieManager->add([
                "nomCategorie" => $nomCategorie
            ]);
            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            Session::addFlash("success", "Votre catégorie a bien été ajoutée");
        } else {
            Session::addFlash("error", "Une erreur est survenue lors de l'ajout de votre catégorie");
        }
        // On redirige vers la liste des catégories
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
            Session::addFlash("success", "Catégorie supprimée avec succès.");
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

                Session::addFlash("success", "Catégorie modifiée avec succès.");
            }
        } else {
            Session::addFlash("error", "Vous n'avez pas les droits pour cet action!");
        }
        $this->redirectTo("forum", "listCategories");
    }

    // Ajouter un post
    public function addPost($id)
    {
        // Si on clique sur le bouton "Ajouter un post" alors on récupère le texte du post et on le filtre, ensuite on vérifie si l'utilisateur est connecté ou qu'il est admin
        $postManager = new PostManager();
        if (isset($_POST["addPost"]) && isset($_SESSION["user"])) {
            // On récupère le champ texte du form et on le filtre
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On ajoute le post selon les données suivantes (texte, user_id, topic_id).
            $data = [
                "texte" => $texte,
                "user_id" => $_SESSION["user"]->getId(),
                "topic_id" => $id
            ];
            $postManager->add($data);
            Session::addFlash("success", "Message ajouté avec succès.");
        } else {
            Session::addFlash("error", "Vous devez être connecté pour faire cet action!");
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
                Session::addFlash("success", "Message supprimé avec succès");
            } else {
                Session::addFlash("error", "Vous ne pouvez pas supprimé le premier message de ce topic"); // On ne peu pas supprimer le premier post du topic
            }
        } else {
            Session::addFlash("error", "Vous devez être connectés pour faire cet action!");
        }
        $this->redirectTo("forum", "listPostsByTopic", $idTopic);
    }

    // Modifier un post
    public function updatePostForm($id)
    {
        $postManager = new PostManager(); // On instancie le manager des posts

        if (isset($_POST["updatePost"]) && isset($_POST["texte"]) && !empty($_POST["texte"]) && (Session::isAdmin()) || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $postManager->findOneById($id)->getUser()->getId())) {
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_SPECIAL_CHARS); // On récupère le champ texte du form et on le filtre
            $topicId = $postManager->findOneById($id)->getTopic()->getId(); // On récupère l'id du topic du post
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
            isset($_POST["addTopic"]) && (Session::isAdmin()) || (isset($_SESSION["user"]))
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
            Session::addFlash("success", "Topic créé avec succès.");
        } else {
            Session::addFlash("error", "Vous devez être connectés pour faire cet action!");
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
        if (!isset($_SESSION["user"])) {
            // On enregistre un message flash
            Session::addFlash("error", "Vous devez être connecté pour modifier");
            // On redirige vers la page de connexion
            $this->redirectTo("security", "login");
        }

        // On instancie les managers
        $topicManager = new TopicManager();
        // On récupère l'id du topic
        $topic = $topicManager->findOneById($id);
        // On récupère le nouveau titre du sujet
        $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // On vérifie que l'action est effectuer par un admin ou l'auteur du topic
        if ((Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId())
        ) {
            // On modifie le titre du sujet
            $topicManager->updateTopic($id, $titre);
        } else {
            // On redirige vers la page du topic
            $this->redirectTo("forum", "listPostsByTopic", $id);
        }
        // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
        if ($topicManager) {
            Session::addFlash("success", "Le titre a bien été modifié");
        } else {
            Session::addFlash("error", "Une erreur est survenue lors de la modification");
        }

        // On redirige vers la page du sujet modifié via l'id du sujet
        $this->redirectTo("forum", "listPostsByTopic", $id);
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

    // Méthode pour afficher le profil de l'utilisateur connecté
    public function profil()
    {
        $userManager = new UserManager(); // On instancie le manager des utilisateurs

        $this->redirectTo("security", "login"); // On redirige vers la page de connexion si l'utilisateur n'est pas connecté
    }
}

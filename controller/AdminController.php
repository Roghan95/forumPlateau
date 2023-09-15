<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;

class AdminController extends AbstractController implements ControllerInterface
{
    // public function index()
    // {
    // }

    // public function listUsers()
    // {
    //     $userManager = new UserManager();
    //     if (!Session::isAdmin()) {
    //         $this->redirectTo("forum", "listCategories");
    //         Session::addFlash("error", "Vous n'avez pas accès à cette page!");
    //     } else {
    //         return [
    //             "view" => VIEW_DIR . "security/listUsers.php",
    //             "data" => [
    //                 "users" => $userManager->findAll(["dateInscription", "DESC"])
    //             ]
    //         ];
    //     }
    //     $this->redirectTo("forum", "listCategories");
    // }

    // // Méthode pour bannir un utilisateur
    // public function banUser($id)
    // {
    //     if (isset($_POST["banUser"])) {
    //         if (Session::isAdmin()) { // Si c'est un admin
    //             $isBan = filter_input(INPUT_POST, 'isBan', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //             $userManager = new UserManager(); // On instancie le manager
    //             $userManager->bannedUser($id, $isBan); // On banni l'user par son id
    //             // var_dump($userManager->bannedUser($id, $isBan));
    //             // die;
    //             Session::addFlash("success", "Utilisateur banni"); // Message de succès
    //         } else {
    //             Session::addFlash("error", "Erreur"); // Message d'erreur
    //         }
    //         $this->redirectTo("security", "listUsers"); // Si réussi on le redirige vers la liste des utilisateurs
    //     }
    //     if (!Session::isAdmin()) { // Si ce n'est pas un admin

    //         Session::addFlash("error", "Vous devez être connecté en tant qu'admin pour bannir un utilisateur"); // Message d'erreur

    //         $this->redirectTo("security", "login"); // On le renvoie vers login
    //     }
    // }

    // public function unbanUser($id)
    // {
    //     if (Session::isAdmin()) { // Si c'est un admin
    //         $userManager = new UserManager(); // On instancie le manager

    //         $userManager->unbanUser($id); // On banni l'user par son id
    //         Session::addFlash("success", "Utilisateur débanni"); // Message de succès
    //     } else {
    //         Session::addFlash("error", "Une erreur est survenue"); // Message d'erreur
    //     }
    //     $this->redirectTo("security", "listUsers"); // Si réussi on le redirige vers la liste des utilisateurs

    //     if (!Session::isAdmin()) { // Si ce n'est pas un admin
    //         Session::addFlash("error", "Vous devez être connecté en tant qu'admin pour débannir un utilisateur"); // Message d'erreur
    //         $this->redirectTo("security", "login"); // On le renvoie vers login
    //     }
    // }
}

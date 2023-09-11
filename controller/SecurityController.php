<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;

class SecurityController extends AbstractController implements ControllerInterface
{
    public function index()
    {
    }

    public function register()
    {
        if (isset($_POST['register'])) {

            // On filtre les différents champs du formulaire
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mdpConfirm = filter_input(INPUT_POST, 'mdpConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On vérifie si les champs on bien été saisi
            if ($email && $pseudo && $mdp && $mdpConfirm) {
                // On instancie le manager
                $userManager = new UserManager();
                // Si l'email n'existe pas alors erreur
                if (!$userManager->findOneByEmail($email)) {
                    // Si le pseudo n'existe pas alors erreur
                    if (!$userManager->findOneByUser($pseudo)) {
                        // On vérifie si le mot de passe correspond et la longueur du mot de passe
                        if (($mdp == $mdpConfirm) and strlen($mdp) >= 3) { // Prévoir de passer la taille minimum à 12 et faire un REGEX
                            // On stock dans "$data" les arguments suivant ->
                            $data = [
                                "pseudo" => $pseudo,
                                "email" => $email,
                                "mdp" => password_hash($mdp, PASSWORD_DEFAULT) // On hash le mot de passe avec BCRYPT (par défaut PHP)
                            ];
                            // On appel à la méthode "add" du manager pour ajouter les arguments stocker dans "$data"
                            $userManager->add($data);
                            // Si c'est un succès on le redirige vers login
                            $this->redirectTo("security", "login");
                        } else {
                            // Les mots de passe ne correspondent pas ou sont trop courts
                            Session::addFlash("error", "Les mots de passe ne correspondent pas ou sont trop courts!");
                        }
                    } else {
                        // Si le pseudo est déjà pris
                        Session::addFlash("error", "Ce pseudo est déjà pris!");
                    }
                } else {
                    // L'email existe déjà
                    Session::addFlash("error", "L'email existe déjà!");
                }
            } else {
                // Vérifier vos saisis..
                Session::addFlash("error", "Vérifier vos saisis...!");
            }
        }
        // On retourne la vue register.php qui contient le formulaire pour s'enregistrer
        return [
            "view" => VIEW_DIR . "security/register.php"
        ];
    }

    public function login()
    {
        if (isset($_POST['login'])) {
            // On instancie le manager
            $userManager = new UserManager();

            // On filtre les différents champs du formulaire de connexion
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On récupère l'email et stock dans "$user"
            $user = $userManager->findOneByEmail($email);

            // On récupère le mot de passe de l'utilisateur
            $hash = $user->getMdp();
            if ($email && $mdp) {
                // On vérifie que l'utilisateur existe bien
                if ($user) {
                    // On vérifie que le mot de passe entrée correspond a celui du compte
                    if (password_verify($mdp, $hash)) {
                        // On ouvre la session
                        Session::setUser($user);
                        // On redirige vers la liste des catégorie si la connexion est réussi
                        $this->redirectTo("forum", "listCategories");
                    } else {
                        // Message ou action si le mot de passe n'est pas le bon
                        Session::addFlash("error", "Email ou mot de passe incorrect!");
                    }
                } else {
                    // Message ou action si aucun compte n'est lié a cet email
                    Session::addFlash("error", "Aucun compte n'existe avec cet email!");
                }
            } else {
                // Message ou action si le filtrage n'est pas passé
                Session::addFlash("error", "Saissisez à nouveau!");
            }
        }
        return [
            "view" => VIEW_DIR . "security/login.php" // On retourne la vue login.php qui contient le formulaire login
        ];
    }

    // Méthode pour se déconnecter
    public function logout()
    {
        unset($_SESSION["user"]); // On déconnecte l'user grâce à la fonction PHP
        $this->redirectTo("forum", "listCategories"); // Redirige vers listCategories ("accueil")
    }

    // public function banUser() {
    //     $userManager = new UserManager();


    // }

    // Méthode pour afficher les utilisateurs
    public function listUsers()
    {
        $userManager = new UserManager();
        return [
            "view" => VIEW_DIR . "security/listUsers.php",
            "data" => [
                "users" => $userManager->findAll(["dateInscription", "DESC"])
            ]
        ];
    }

    // Méthode pour ban un utilisateur
    public function banUser()
    {
        $userManager = new UserManager();
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        $banUser = filter_input(INPUT_GET, "dateBan", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($id) {
            $userManager->banUser($id, $banUser);
            $this->redirectTo("security", "listUsers");
        }
    }
}

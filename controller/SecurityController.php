<?php

namespace Controller;


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
            // var_dump("ok");
            // die;
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mdpConfirm = filter_input(INPUT_POST, 'mdpConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            if ($email && $pseudo && $mdp && $mdpConfirm) {
                $userManager = new UserManager();
                if (!$userManager->findOneByEmail($email)) {
                    if (!$userManager->findOneByUser($pseudo)) {
                        if (($mdp == $mdpConfirm) and strlen($mdp) >= 3) {
                            $data = [
                                "pseudo" => $pseudo,
                                "email" => $email,
                                "mdp" => password_hash($mdp, PASSWORD_DEFAULT)
                            ];
                            $userManager->add($data);
                            // $this->redirectTo("security", "login");
                        } else {
                            // Les mots de passe ne correspondent pas ou sont trop courts
                            echo "<p>Les mots de passe ne correspondent pas ou sont trop courts</p>";
                        }
                    }
                } else {
                    // L'email ou le pseudo existe déjà
                    echo "<p>L'email ou le pseudo existe déjà</p>";
                }
            }
        }
        return [
            "view" => VIEW_DIR . "security/register.php"
        ];
    }

    public function login()
    {
        if (isset($_POST['login'])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userManager = new UserManager();
            $userMdp = $userManager->findOneByEmail($email)->getMdp();
            if ($email && password_verify($mdp, $userMdp)) {
            }
        }
        // return [
        //     "view" => VIEW_DIR . "security/login.php"
        // ];
    }
}

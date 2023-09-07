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
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mdpConfirm = filter_input(INPUT_POST, 'mdpConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            if ($email && $pseudo && $mdp && $mdpConfirm) {
                // var_dump("ok");
                // die;
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
                            $this->redirectTo("security", "login.php");
                            exit;
                        } else {
                            // Les mots de passe ne correspondent pas ou sont trop courts
                        }
                    }
                } else {
                    // L'email ou le pseudo existe déjà;
                }
            }
        }
    }
}

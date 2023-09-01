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
            var_dump($_POST);
            die;
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
            $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
            $confirmMdp = filter_input(INPUT_POST, 'confirmMdp', FILTER_SANITIZE_STRING);


            if ($email && $pseudo && $mdp) {
                $userManager = new UserManager();

                if (!$userManager->findOneByEmail($email)) {
                    if (!$userManager->findOneByUser($pseudo)) {
                        if (($mdp == $confirmMdp) and strlen($mdp) >= 8) {
                        }
                    }
                }
            }
        } else {
            return [
                "view" => VIEW_DIR . "register.php"
            ];
        }
    }
}

// return [
//     "view" => VIEW_DIR . "register.php"
// ];
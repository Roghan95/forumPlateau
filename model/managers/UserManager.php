<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager
{

    protected $className = "Model\Entities\User";
    protected $tableName = "user";


    public function __construct()
    {
        parent::connect();
    }

    public function findOneByEmail($email)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, [":email" => $email], false),
            $this->className
        );
    }

    public function findOneByUser($pseudo)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE pseudo = :pseudo
        ORDER BY dateInscription ASC";

        return $this->getOneOrNullResult(
            DAO::select($sql, [":pseudo" => $pseudo], false),
            $this->className
        );
    }

    // Requete pour ban un utilisateur
    public function banUser($id, $isBan)
    {
        $sql = "UPDATE " . $this->tableName . " user
        SET user.isBan = :isBan
        WHERE user.id = :id";

        return DAO::update($sql, [":id" => $id, ":isBan" => $isBan]);
    }

    // Requete pour unban un utilisateur
    public function unbanUser($id)
    {
        $sql = "UPDATE " . $this->tableName . " user
        SET user.isBan = NULL
        WHERE user.id = :id";

        return DAO::update($sql, [":id" => $id]);
    }

    public function profilUser($id)
    {
        $sql = "SELECT * FROM " . $this->tableName . " 
        WHERE id = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, [":id" => $id]),
            $this->className
        );
    }
}

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
        $sql = "SELECT * FROM " . $this->tableName . " WHERE pseudo = :pseudo";

        return $this->getOneOrNullResult(
            DAO::select($sql, [":pseudo" => $pseudo], false),
            $this->className
        );
    }
}

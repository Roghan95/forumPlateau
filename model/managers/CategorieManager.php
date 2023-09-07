<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class CategorieManager extends Manager
{

    protected $className = "Model\Entities\Categorie";
    protected $tableName = "categorie";


    public function __construct()
    {
        parent::connect();
    }

    public function updateCategorie($id, $nomCategorie)
    {
        $sql = "UPDATE categorie
        SET nomCategorie = :nom
        WHERE id_categorie = :id";

        return DAO::update($sql, ['id' => $id, 'nom' => $nomCategorie]);
    }
}

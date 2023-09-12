<?php

namespace Model\Entities;

use App\Entity;

final class Categorie extends Entity
{
    private $id;
    private $nomCategorie;
    private $dateCreation;



    public function __construct($data)
    {
        $this->hydrate($data);
    }

    public function getDateCreation()
    {
        $formattedDate = $this->dateCreation->format("d/m/Y, H:i:s");
        return $formattedDate;
    }

    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = new \DateTime($dateCreation);
        return $this;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getNomCategorie()
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie($nomCategorie)
    {
        $this->nomCategorie = $nomCategorie;
        return $this;
    }

    public function __toString()
    {
        return $this->nomCategorie;
    }
}

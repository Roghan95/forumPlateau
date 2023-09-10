<?php

namespace Model\Entities;

use App\Entity;

final class User extends Entity
{
    private $id;
    private $pseudo;
    private $mdp;
    private $dateInscription;
    private $role;
    private $email;
    private $isBan;


    public function __construct($data)
    {
        $this->hydrate($data);
    }

    public function getIsBan()
    {
        return $this->isBan;
    }

    public function setIsBan($isBan)
    {
        $this->isBan = $isBan;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getMdp()
    {
        return $this->mdp;
    }

    public function setMdp($mdp)
    {
        $this->mdp = $mdp;
    }

    public function getDateInscription()
    {
        $formattedDate = $this->dateInscription->format("d/m/Y, H:i:s");
        return $formattedDate;
    }

    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = new \DateTime($dateInscription);
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    // Méthode pour vérifier le role d'un utilisateur
    public function hasRole($role)
    {
        if ($this->role == $role) {
            return true;
        } else {
            return false;
        };
    }

    public function __toString()
    {
        return $this->pseudo;
    }
}

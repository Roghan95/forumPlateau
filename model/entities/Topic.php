<?php

namespace Model\Entities;

use App\Entity;

final class Topic extends Entity
{

        private $id;
        private $titre;
        private $user;
        private $dateCreation;
        private $locked;
        private $categorie;
        private $nbPosts;

        public function __construct($data)
        {
                $this->hydrate($data);
        }

        // On récupère le nombre de posts par topic
        public function getNbPosts()
        {
                return $this->nbPosts;
        }

        // On set le nombre de posts par topic
        public function setNbPosts($nbPosts)
        {
                $this->nbPosts = $nbPosts;

                return $this;
        }

        // On récupère la catégorie
        public function getCategorie()
        {
                return $this->categorie;
        }

        // On set la catégorie
        public function setCategorie($categorie)
        {
                $this->categorie = $categorie;
                return $this;
        }
        // On récupère l'id
        public function getId()
        {
                return $this->id;
        }
        // On set l'id
        public function setId($id)
        {
                $this->id = $id;
                return $this;
        }
        // On récupère le titre
        public function getTitre()
        {
                return $this->titre;
        }
        // On set le titre
        public function setTitre($titre)
        {
                $this->titre = $titre;

                return $this;
        }
        // On récupère l'user
        public function getUser()
        {
                return $this->user;
        }

        // On set l'user
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }
        // On récupère la date de création
        public function getDateCreation()
        {
                $formattedDate = $this->dateCreation->format("d/m/Y, H:i:s");
                return $formattedDate;
        }
        // On set la date de création
        public function setDateCreation($dateCreation)
        {
                $this->dateCreation = new \DateTime($dateCreation);
                return $this;
        }
        // On récupère le locked
        public function getLocked()
        {
                return $this->locked;
        }
        // On set le locked
        public function setLocked($locked)
        {
                $this->locked = $locked;

                return $this;
        }
        // On affiche le titre en string
        public function __toString()
        {
                return $this->titre;
        }
}

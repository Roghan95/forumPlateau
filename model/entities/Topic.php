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

        public function setCategorie($categorie)
        {
                $this->categorie = $categorie;
                return $this;
        }

        /**
         * Get the value of id
         */
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of titre
         */
        public function getTitre()
        {
                return $this->titre;
        }

        /**
         * Set the value of titre
         *
         * @return  self
         */
        public function setTitre($titre)
        {
                $this->titre = $titre;

                return $this;
        }

        /**
         * Get the value of user
         */
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
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

        /**
         * Get the value of locked
         */
        public function getLocked()
        {
                return $this->locked;
        }

        /**
         * Set the value of locked
         *
         * @return  self
         */
        public function setLocked($locked)
        {
                $this->locked = $locked;

                return $this;
        }

        public function __toString()
        {
                return $this->titre;
        }
}

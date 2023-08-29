<?php
    namespace Model\Entities;

    use App\Entity;

    final class Categorie extends Entity {
        private $categorie;
        private $nom_categorie;


        public function __construct($data) {
            $this->hydrate($data);
        }


        public function getCategorie() {
            return $this->categorie;
        }

        public function setCategorie($categorie) {
            $this->categorie = $categorie;
            return $this;
        }

        public function getNom_categorie() {
            return $this->nom_categorie;
        }

        public function setNom_categorie($nom_categorie) {
            $this->nom_categorie = $nom_categorie;
            return $this;
        }
    }
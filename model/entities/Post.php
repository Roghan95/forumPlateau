<?php 

namespace Model\Entities;

use App\Entity;

final class Post extends Entity {
    private $id;
    private $texte;
    private $date_creation;
    private $user;
    private $topic;


    public function __construct($data) {
        $this->hydrate($data);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTexte() {
        return $this->texte;
    }

    public function setTexte($texte) {
        $this->texte = $texte;
    }

    public function getDate_creation() {
        $formattedDate = $this->date_creation->format("d/m/Y, H:i:s");
            return $formattedDate;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = new \DateTime($date_creation);
        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getTopic() {
        return $this->topic;
    }

    public function setTopic($topic) {
        $this->topic = $topic;
    }
}
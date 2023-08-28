<?php 

final class Post extends Entity {
    private $id;
    private $text;
    private $datePost;
    private $user;
    private $topic;


    public function __construct($id, $text, $datePost, $user, $topic) {
        $this->hydrate($id);
        $this->hydrate($text);
        $this->hydrate($datePost);
        $this->hydrate($user);
        $this->hydrate($topic);
    }
}
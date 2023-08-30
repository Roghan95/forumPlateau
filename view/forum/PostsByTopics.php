<?php

$posts = $result["data"]['posts'];
$topics = $result["data"]['topics'];

foreach ($posts as $post) {
    $premiereValeur = $post;
    break;
}




?>
<!--....... &id=<  ?= $premiereValeur->getTopic()->getCategorie()->getId()  ?> -->
<h1>
    <a href="index.php?ctrl=forum&action=listCategories">Catégories</a> >
    <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $premiereValeur->getTopic()->getCategorie()->getId() ?>"><?= $premiereValeur->getTopic()->getCategorie()->getNomCategorie() ?></a>
    <?= $topics->getTitre() ?>
</h1>

<div class="posts-container">
    <?php foreach ($posts as $post) { ?>
        <div class="post-block">
            <div class="post-info">
                <figure>
                    <img src="https://picsum.photos/50/50" alt="">
                </figure>
                <div class="user-date">
                    <a href="#">[Script user]</a>
                    <p>Le <?= $post->getDateCreation() ?></p>
                </div>
            </div>
            <p><?= $post->getTexte() ?></p>
        </div>
    <?php } ?>
</div>
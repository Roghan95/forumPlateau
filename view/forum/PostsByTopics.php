<?php

$posts = $result["data"]['posts'];
$topics = $result["data"]['topics'];

foreach ($posts as $post) {
    $firstValue = $post;
    break;
}

?>
<h1>
    <a href="index.php?ctrl=forum&action=listCategories">Catégories</a> >
    <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $firstValue->getTopic()->getCategorie()->getId() ?>"><?= $firstValue->getTopic()->getCategorie()->getNomCategorie() ?></a>
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
                    <a href="#"></a>
                    <p>Le <?= $post->getDateCreation() ?></p>
                </div>
            </div>
            <p>
                <?= $post->getTexte() ?>
            </p>
        </div>
    <?php } ?>
    <form class="reponse-form" action="index.php?ctrl=forum&action=addPost" method="post">
        <label for="message-textarea">Répondre: </label>
        <textarea id="message-textarea" name="text" required></textarea>
        <button type="submit" name="text">POSTER</button>
    </form>
</div>
<?php

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];
?>
<h1>
    <a href="index.php?ctrl=forum&action=listCategories">Catégories</a> >
    <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $topic->getCategorie()->getId() ?>"><?= $topic->getCategorie()->getNomCategorie() ?></a>
    >
    <?= $topic->getTitre() ?>
</h1>

<div class="posts-container">
    <?php
    if ($posts) {
        foreach ($posts as $post) { ?>
            <div class="post-block">
                <div class="post-info">
                    <figure>
                        <img src="https://picsum.photos/50/50" alt="Photo de profil">
                        <!-- On affiche le pseudo de l'utilisateur qui a créer le post -->
                        <p><?= $post->getUser() ?></p>
                    </figure>
                    <div class="user-date">
                        <!-- On affiche la date de création du post -->
                        <p>Le <?= $post->getDateCreation() ?></p>
                    </div>
                </div>
                <p>
                    <!-- On affiche le texte du post -->
                    <?= $post->getTexte() ?>
                </p>
            </div>
    <?php }
    } else {
        echo "<p>Pas de posts dans ce topic</p>";
    }
    ?>
    <form class="reponse-form" action="index.php?ctrl=forum&action=addPost&id=<?= $topics->getId() ?>" method="post">
        <label for="message-textarea">Répondre: </label>
        <textarea id="message-textarea" name="texte" required></textarea>
        <input type="submit" name="addPost">POSTER</input>
    </form>
</div>
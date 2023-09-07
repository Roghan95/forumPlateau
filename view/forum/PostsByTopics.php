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

<?php if (empty($posts)) {
    echo "Aucun message n'a été trouvé dans ce topic.";
?>
<?php } else { ?>
    <div class="posts-container">
        <?php
        foreach ($posts as $post) { ?>
            <div class="post-info">
                <figure>
                    <img src="https://picsum.photos/50/50" alt="Photo de profil">
                    <!-- On affiche le pseudo de l'utilisateur qui a créer le post -->
                    <p><?= $post->getUser() ?></p>
                </figure>
                <!-- On affiche la date de création du post -->
                <p>Le <?= $post->getDateCreation() ?></p>
            </div>
            <div class="text-area">
                <p>
                    <!-- On affiche le texte du post -->
                    <?= $post->getTexte() ?>
                </p>
            </div>
            <form action="index.php?ctrl=forum&action=updatePost&id=<?= $topic->getId() ?>" method="post">
                <textarea name="texte" id="" cols="30" rows="10" placeholder="Votre message" required></textarea>
                <input type="submit" name="updatePost" value="Modifier">
            </form>
        <?php } ?>
        <form class="reponse-form" action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="post">
            <label for="message-textarea">Répondre: </label>
            <textarea id="message-textarea" name="texte" required></textarea>
            <input type="submit" name="addPost" value="POSTER">
        </form>
    </div>
<?php } ?>
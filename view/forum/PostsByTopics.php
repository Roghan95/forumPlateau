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
    <!-- <button>Supp.Topic</button>
    <button>Vérouiller</button> -->
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

            <!-- Form pour modifier le post avec un input type submit -->
            <?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $post->getUser()->getId())) { ?>
                <form action="index.php?ctrl=forum&action=updatePostForm&id=<?= $post->getId() ?>" method="post">
                    <textarea type="text" name="texte" placeholder="Modifier le texte"></textarea>
                    <input class="submit" type="submit" name="updatePost" value="Modifier">
                </form>
                <a class="submit" href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>">Supprimer</a>
            <?php } ?>
        <?php } ?>

        <?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $post->getUser()->getId())) { ?>
            <!-- Form qui permet de répondre a un post -->
            <form class="reponse-form" action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="post">
                <label for="message-textarea">Répondre: </label>
                <textarea id="message-textarea" name="texte" required></textarea>
                <input class="submit" type="submit" name="addPost" value="POSTER">
            </form>
        <?php } ?>
    </div>
<?php } ?>
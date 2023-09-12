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
        <!-- On vérifie si l'utilisateur est admin ou l'auteur pour afficher lock et unlock -->
        <?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId())) { ?>
            <form action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" method="post">
                <input class="titre-form" type="text" name="titre" placeholder="Modifier le titre" required>
                <input class="submit" type="submit" name="updateTopic" value="Modifier">
            </form>
            <!-- Bouton supprimer un topic -->
            <a class="submit" href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer</a>
        <?php } ?>

        <?php if ((App\Session::isAdmin())) { ?>
            <?php if ($topic->getLocked() == 0) { ?>
                <a class="lock" href="index.php?ctrl=forum&action=lockTopic&id=<?= $topic->getId() ?>">Verrouiller</a>
            <?php } else { ?>
                <a class="unlock" href="index.php?ctrl=forum&action=unlockTopic&id=<?= $topic->getId() ?>">Deverrouiller</a>
            <?php } ?>
        <?php } ?>

        <?php foreach ($posts as $post) { ?>
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
            <!-- On vérifie si l'utilisateur est admin ou l'auteur du post pour permettre la modification du post -->
            <div class="modifier-post">
                <?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $post->getUser()->getId())) { ?>
                    <form action="index.php?ctrl=forum&action=updatePostForm&id=<?= $post->getId() ?>" method="post">
                        <textarea type="text" name="texte" placeholder="Modifier le texte" required></textarea>
                        <input class="submit" type="submit" name="updatePost" value="Modifier">
                    </form>
                    <a class="submit" href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>">Supprimer</a>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]))) { ?>
            <!-- On vérifie que le topic n'est pas lock pour afficher le formulaire d'ajout de post -->
            <?php if ($topic->getLocked() == 0) { ?>
                <!-- Form qui permet de répondre a un post -->
                <form class="reponse-form" action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="post">
                    <label for="message-textarea">Répondre: </label>
                    <textarea id="message-textarea" name="texte" required></textarea>
                    <input class="submit" type="submit" name="addPost" value="POSTER">
                </form>
            <?php }else { ?>
                <p>Le topic est verrouillé</p> <?php }
        } else { ?>
            <!-- Si non on affiche un message qui dit que c'est verrouillé -->
            <p>Le topic est verrouillé</p>
        <?php } ?>
    <?php } ?>
    </div>
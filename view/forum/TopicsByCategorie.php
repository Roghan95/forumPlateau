<?php

$topics = $result["data"]['topics'];
$categories = $result["data"]['categories'];

?>

<h1>
    <a href="index.php?ctrl=forum&action=listCategories">Catégories</a>
    >
    <?= $categories->getNomCategorie() ?>
</h1>

<?php
if (empty($topics)) { ?>
    <?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId())) { ?>
        <form action="index.php?ctrl=forum&action=addTopic&id=<?= $categories->getId() ?>" method="post">
            <label for="">Ajouter un sujet</label>
            <input class="titre-form" type="text" name="titre" placeholder="Sujet : ">
            <textarea name="texte" placeholder="Message"></textarea>
            <input class="submit" type="submit" name="addTopic" value="OK">
        </form>
    <?php } else {
        echo "Aucun sujet n'a été trouvé dans cette catégorie.";
    } ?>
<?php } else { ?>
    <table border=1>
        <tr>
            <th>Sujet</th>
            <th>Auteur</th>
            <th>NB Messages</th>
            <th>Date</th>
        </tr>
        <?php foreach ($topics as $topic) { ?>
            <tr>
                <td>
                    <a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>">
                        <?= $topic->getTitre() ?>
                    </a>
                    <?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId())) { ?>
                        <form action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" method="post">
                            <input class="titre-form" type="text" name="titre" placeholder="Modifier le titre">
                            <input class="submit" type="submit" name="updateTopic" value="Modifier">
                        </form>
                        <a class="submit" href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer</a>
                    <?php } ?>
                </td>
                <td>
                    <a href="">
                        <?= $topic->getUser() ?>
                    </a>
                </td>
                <td>
                    <p>
                        <?= $topic->getNbPosts() ?>
                    </p>
                </td>
                <td>
                    <p>
                        <?= $topic->getDateCreation() ?>
                    </p>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]))) { ?>
        <form action="index.php?ctrl=forum&action=addTopic&id=<?= $categories->getId() ?>" method="post">
            <input class="titre-form" type="text" name="titre" placeholder="Sujet :">
            <textarea name="texte" placeholder="Message"></textarea>
            <input class="submit" type="submit" name="addTopic" value="Poster">
        </form>
    <?php } ?>
<?php } ?>
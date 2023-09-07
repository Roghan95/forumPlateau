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
    <h2>Ajouter un sujet</h2>
    <form action="index.php?ctrl=forum&action=addTopic&id=<?= $categories->getId() ?>" method="post">
        <input type="text" name="titre" placeholder="Sujet : ">
        <textarea name="texte" id="" cols="30" rows="10" placeholder="Message"></textarea>
        <input type="submit" name="addTopic" value="OK">
    </form>
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
                    <form action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" method="post">
                        <input type="text" name="titre" placeholder="Modifier le titre">
                        <input type="submit" name="updateTopic" value="Modifier">
                    </form>
                    <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer</a>
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
    <form action="index.php?ctrl=forum&action=addTopic&id=<?= $categories->getId() ?>" method="post">
        <input type="text" name="titre" placeholder="Sujet :">
        <textarea name="texte" id="" cols="30" rows="10" placeholder="Message"></textarea>
        <input type="submit" name="addTopic" value="OK">
    </form>
<?php } ?>
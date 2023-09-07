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
    <p>Aucun sujet n'a été trouvé dans cette catégorie.</p>
    <form action="index.php?ctrl=forum&action=addTopic&id=<?= $categories->getId() ?>" method="post">
        <label for="titre">Ajouter un sujet</label>
        <input type="text" name="titre">
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
                    <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer</a>
                    <form action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" method="post">
                        <input type="text" name="updateTopic" placeholder="Modifier le titre">
                        <input type="submit" name="updateTopic" value="Modifier">
                    </form>
                </td>
                <td>
                    <a href="">
                        <?= $topic->getUser() ?>
                    </a>d
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
        <label for="titre">Ajouter un topic :</label>
        <input type="text" name="titre" placeholder="Titre">
        <input type="submit" name="addTopic" value="OK">
    </form>
<?php } ?>
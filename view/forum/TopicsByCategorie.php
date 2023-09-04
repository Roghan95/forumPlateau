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

if (empty($topics)) : ?>
    <p>Aucun sujet n'a été trouvé dans cette catégorie.</p>
<?php else : ?>
    <table border=1>
        <tr>
            <th>Sujet</th>
            <th>Auteur</th>
            <th>NB Messages</th>
            <th>Date</th>
        </tr>
        <?php foreach ($topics as $topic) : ?>
            <tr>
                <td>
                    <a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>">
                        <?= $topic->getTitre() ?>
                    </a>
                </td>
                <td>
                    <a href="">
                        <?= $topic->getUser() ?>
                    </a>
                </td>
                <td>[insérer le script]</td>
                <td>
                    <a href="">
                        <?= $topic->getDateCreation() ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
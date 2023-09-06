<?php

$topics = $result["data"]['topics'];

?>

<h1>Liste topics</h1>

<?php
foreach ($topics as $topic) {
?>
    <div class="topics-container">
        <div class="topics-list">
            <p>
                <a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>">
                    <?= $topic->getTitre() ?>
                </a>
            </p>
        </div>
        <div class="topics-delete">
            <form action="" method="post">
                <input type="submit" name="deleteTopic" value="Supprimer">
            </form>
        </div>
    <?php } ?>
    <div class="topics-add">
        <form action="" method="post">
            <input type="text" name="addTopic" id="titre" placeholder="Ajouter un topic">
            <input type="submit" name="addTopic" value="Ajouter">
        </form>
    </div>
    </div>
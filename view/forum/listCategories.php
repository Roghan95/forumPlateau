<?php
$categories = $result["data"]['categories'];
?>


<div class="container">
    <h1>FORUM</h1>
    <div class="categorie">
        <div class="box">
            <form action="" method="post">
                <input type="text" name="nomCategorie">
                <input type="submit" name="addCategorie" value="Ajouter une catégorie">
            </form>
            <?php foreach ($categories as $categorie) { ?>
                <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $categorie->getId() ?>">
                    <p><?= $categorie->getNomCategorie() ?></p>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
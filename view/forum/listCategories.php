<?php
$categories = $result["data"]['categories'];
?>


<div class="container">
    <h1>FORUM</h1>
    <div class="categorie">
        <div class="box">
            <?php foreach ($categories as $categorie) { ?>
                <!-- Affiche le nom de la catégorie -->
                <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $categorie->getId() ?>">
                    <p><?= $categorie->getNomCategorie() ?></p>
                    <!-- Bouton deleteCategorie -->
                    <form action="index.php?ctrl=forum&action=deleteCategorie&id=<?= $categorie->getId() ?>" method="post">
                        <input type="submit" name="deleteCategorie" value="Supprimer">
                    </form>
                </a>
            <?php } ?>
            <form action="index.php?ctrl=forum&action=addCategorie" method="post">
                <label for="nomCategorie">Ajouter une catégorie</label>
                <input type="text" name="nomCategorie">
                <input type="submit" name="addCategorie" value="OK">
            </form>
        </div>
    </div>
</div>
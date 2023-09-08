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

                    <?php if ((App\Session::isAdmin())) { ?>
                        <a href="index.php?ctrl=forum&action=deleteCategorie&id=<?= $categorie->getId() ?>">Supprimer</a>
                    <?php } ?>
                </a>
                <?php if ((App\Session::isAdmin())) { ?>
                    <form action="index.php?ctrl=forum&action=updateCategorie&id=<?= $categorie->getId() ?>" method="post">
                        <input type="text" name="nomCategorie" placeholder="Modifier le titre" required>
                        <input type="submit" name="updateCategorie" value="Modifier">
                    </form>
                <?php } ?>
            <?php } ?>
            <?php if ((App\Session::isAdmin())) { ?>
                <form action="index.php?ctrl=forum&action=addCategorie" method="post">
                    <label for="nomCategorie">Ajouter une catégorie :</label>
                    <input type="text" name="nomCategorie" placeholder="Nom de la catégorie" required>
                    <input type="submit" name="addCategorie" value="Ajouter">
                </form>
            <?php } ?>
        </div>
    </div>
</div>
<!-- index.php?ctrl=forum&action=updateCategorie&id= -->
<?php
$categories = $result["data"]['categories'];
$nbTopics = $result["data"]['tabId'];
$allTopics = $result["data"]['allTopics'];


?>



<h1>FORUM</h1>
<div class="categorie">
    <h2>Liste catégories</h2>
    <div class="list-categ">
        <?php

        if ($categories) {
            foreach ($categories as $index => $categorie) {
                $pourcentageTopics = ($nbTopics[$index] / $allTopics) * 100; // On calcule le pourcentage de topics de chaque categorie par rapport au nombre total de topics
        ?>

                <div class="edit-form">
                    <a class="nomCateg" href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $categorie->getId() ?>">
                        <?= $categorie->getNomCategorie() ?> <!-- On récupère les noms des catégories -->
                    </a>
                    <p><?= $categorie->getDateCreation() ?></p>
                    <div>
                        <p>Topics : <?= $nbTopics[$index] ?></p>
                        <div class="barre_noir">
                            <div style="width: <?= $pourcentageTopics ?>%;" class="barre_bleu"></div>
                        </div>
                    </div>
                    <?php if ((App\Session::isAdmin())) { ?> <!-- // On vérifie si l'utilisateur est admin pour afficher le bouton de suppression et modification -->
                        <div class="modifyDelete">
                            <div>
                                <form action="index.php?ctrl=forum&action=updateCategorie&id=<?= $categorie->getId() ?>" method="post">
                                    <input class="modify-title" type="text" name="nomCategorie" placeholder="Modifier le titre" required>
                                    <input class="btn-modify" type="submit" name="updateCategorie" value="Modifier">
                                </form>
                            </div>
                            <a class="supp-categ" href="index.php?ctrl=forum&action=deleteCategorie&id=<?= $categorie->getId() ?>">Suppr.</a>
                        </div>
                    <?php } ?>
                </div>
        <?php }
        } ?>
    </div>
    <?php if ((App\Session::isAdmin())) { ?>
        <form action="index.php?ctrl=forum&action=addCategorie" method="post">
            <label for="nomCategorie">Ajouter une catégorie :</label>
            <input class="nom-categ" type="text" name="nomCategorie" placeholder="Nom de la catégorie" required>
            <input class="add-categ" type="submit" name="addCategorie" value="Ajouter">
        </form>
    <?php } ?>
</div>

<!-- http://localhost/forumPlateau/index.php?ctrl=forum&action=listTopicsByCategorie&id=29
http://localhost/forumPlateau/index.php?ctrl=forum&action=listTopicsByCategorie&id=52 -->
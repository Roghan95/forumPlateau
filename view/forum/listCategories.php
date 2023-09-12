<?php
$categories = $result["data"]['categories'];
?>


<h1>FORUM</h1>
<h2>Liste catégories</h2>
<div class="categorie">
    <div class="list-categ">
        <?php
        if ($categories) {
            foreach ($categories as $categorie) { ?>
                <div class="edit-form">
                    <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $categorie->getId() ?>">
                        <?= $categorie->getNomCategorie() ?> <!-- On récupère les noms des catégories -->
                    </a>
                    <?php if ((App\Session::isAdmin())) { ?> <!-- // On vérifie si l'utilisateur est admin pour afficher le bouton de suppression -->
                        <div class="modifyDelete">
                            <div>
                                <form action="index.php?ctrl=forum&action=updateCategorie&id=<?= $categorie->getId() ?>" method="post">
                                    <input class="modify-title" type="text" name="nomCategorie" placeholder="Modifier le titre" required>
                                    <input class="btn-modify" type="submit" name="updateCategorie" value="Modifier">
                                </form>
                            </div>
                            <a class="supp-categ" href="index.php?ctrl=forum&action=deleteCategorie&id=<?= $categorie->getId() ?>">Supprimer</a>
                        </div>
                    <?php } ?>
                </div>
        <?php }
        } ?>
    </div>
    <?php if ((App\Session::isAdmin())) { ?>
        <form action="index.php?ctrl=forum&action=addCategorie" method="post">
            <label for="nomCategorie">Ajouter une catégorie :</label>
            <input type="text" name="nomCategorie" placeholder="Nom de la catégorie" required>
            <input type="submit" name="addCategorie" value="Ajouter">
        </form>
    <?php } ?>
</div>
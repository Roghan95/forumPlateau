<?php
$categories = $result["data"]['categories'];
$nbTopics = $result["data"]['tabId'];
$allTopics = $result["data"]['allTopics'];


?>



<h1>FORUM</h1>
<div class="categorie">
    <h2>Liste catégories</h2>
    <?php
    if ($categories) {
        foreach ($categories as $index => $categorie) {
            $pourcentageTopics = ($nbTopics[$index] / $allTopics) * 100; // On calcule le pourcentage de topics de chaque categorie par rapport au nombre total de topics
    ?>
            <div class="edit-form">
                <div>
                    <a class="nomCateg" href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $categorie->getId() ?>">
                        <?= $categorie->getNomCategorie() ?> <!-- On récupère les noms des catégories -->
                    </a>
                    <p style="color: grey; text-align:left !important; font-size: 12px; font-weight:600;"><?= $categorie->getDateCreation() ?></p>
                </div>
                <div>
                    <p>Topics : <?= $nbTopics[$index] ?></p>
                    <div class="barre_noir">
                        <div style="width: <?= $pourcentageTopics ?>%;" class="barre_bleu"></div>
                    </div>
                </div>
                <?php if ((App\Session::isAdmin())) { ?> <!-- // On vérifie si l'utilisateur est admin pour afficher le bouton de suppression et modification -->
                    <div class="modifyDelete">
                        <form class="form-modify" action="index.php?ctrl=forum&action=updateCategorie&id=<?= $categorie->getId() ?>" method="post">
                            <input style="display: none;" class="modify-title" type="text" name="nomCategorie" placeholder="Modifier le titre" required>
                            <input class="btn-modify" type="submit" name="updateCategorie" value="Modifier">
                        </form>
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
        <input style="display: none;" class="nom-categ" type="text" name="nomCategorie" placeholder="Nom de la catégorie" required>
        <input class="add-categ" type="submit" name="addCategorie" value="Ajouter">
    </form>
<?php } ?>

<script>
    // input modifier titre catégorie qui apparait quand on clique sur le bouton modifier
    const modifyTitle = document.querySelectorAll(".modify-title");
    const btnModify = document.querySelectorAll(".btn-modify");
    const nomCateg = document.querySelectorAll(".nomCateg");
    const addCateg = document.querySelector(".add-categ");

    for (let i = 0; i < btnModify.length; i++) {
        btnModify[i].addEventListener("click", function() {
            modifyTitle[i].style.display = "inline-block";
        })
    }

    // Si le l'input est vide, on affiche un bouton pour refermer l'input
    for (let i = 0; i < modifyTitle.length; i++) {
        modifyTitle[i].addEventListener("blur", function() {
            if (modifyTitle[i].value == "") {
                modifyTitle[i].style.display = "none";
            }
        })
    }

    // input ajouter catégorie qui apparait quand on clique sur le bouton ajouter
    addCateg.addEventListener("click", function() {
        const nomCateg = document.querySelector(".nom-categ");
        nomCateg.style.display = "block";
    })
</script>
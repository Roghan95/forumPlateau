<?php

$categories = $result["data"]['categories'];
    
?>

<h1>Liste categories</h1>

<?php
foreach($categories as $categorie){ ?>
    <a href="index.php?ctrl=forum&action=listCategories&id=<?= $categorie->getId()?>"></a>
    <p><?=$categorie->getNomCategorie()?></p>
<?php
}
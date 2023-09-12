<?php

$topics = $result["data"]['topics'];
$categories = $result["data"]['categories'];

?>

<h1>
    <!-- Catégories Topic Post -->
    <a href="index.php?ctrl=forum&action=listCategories">Catégories</a>
    >
    <?= $categories->getNomCategorie() ?>
</h1>

<?php if (empty($topics)) { ?>
    <?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]) && $_SESSION["user"])) { ?> <!-- Si l'utilisateur est connecté ou admin, il peut ajouter un sujet -->
        <form action="index.php?ctrl=forum&action=addTopic&id=<?= $categories->getId() ?>" method="post">
            <label for="">Ajouter un sujet</label>
            <input class="titre-form" type="text" name="titre" placeholder="Sujet : " required>
            <textarea name="texte" placeholder="Message" required></textarea>
            <input class="submit" type="submit" name="addTopic" value="OK">
        </form>
    <?php } ?>
<?php } ?>

<?php if (!empty($topics)) { ?>
    <table border=1>
        <thead>
            <tr>
                <th>Sujet</th>
                <th>Auteur</th>
                <th>NB Messages</th>
                <th>Date</th>
                <th>Etat</th>
            </tr>
        </thead>
        <?php foreach ($topics as $topic) { ?>
            <tr>
                <td>
                    <a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>">
                        <?= $topic->getTitre() ?>
                    </a>
                </td>
                <td>
                    <a href="index.php?ctrl=forum&action=profil">
                        <!-- TODO : Lien vers la page de profil de l'utilisateur -->
                        <?= $topic->getUser() ?>
                    </a>
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
                <td>
                    <?php if ($topic->getLocked() == 1) { ?>
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 30 30">
                            <path d="M 15 2 C 11.145666 2 8 5.1456661 8 9 L 8 11 L 6 11 C 4.895 11 4 11.895 4 13 L 4 25 C 4 26.105 4.895 27 6 27 L 24 27 C 25.105 27 26 26.105 26 25 L 26 13 C 26 11.895 25.105 11 24 11 L 22 11 L 22 9 C 22 5.2715823 19.036581 2.2685653 15.355469 2.0722656 A 1.0001 1.0001 0 0 0 15 2 z M 15 4 C 17.773666 4 20 6.2263339 20 9 L 20 11 L 10 11 L 10 9 C 10 6.2263339 12.226334 4 15 4 z"></path>
                        </svg>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
<?php if ((App\Session::isAdmin()) || (isset($_SESSION["user"]))) { ?> <!-- Si l'utilisateur est connecté ou admin, il peut ajouter un sujet -->
    <form action="index.php?ctrl=forum&action=addTopic&id=<?= $categories->getId() ?>" method="post">
        <input class="titre-form" type="text" name="titre" placeholder="Sujet :" required>
        <textarea name="texte" placeholder="Message" required></textarea>
        <input class="submit" type="submit" name="addTopic" value="Poster">
    </form>
<?php } ?>
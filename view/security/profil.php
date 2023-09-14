<?php
$users = $result["data"]["user"];
$posts = $result["data"]["posts"];
$isAuthor = (isset($_SESSION["user"]) && ($_SESSION["user"]->getId() == $users->getId()));
$isAdmin = App\Session::isAdmin();
$isBan = $users->getIsBan() !== null;
?>


<h1>Profil</h1>
<figure>
    <img src="https://picsum.photos/50/50" alt="Photo de profil">
    <p><?= $users->getPseudo() ?></p>
</figure>

<?php if ($isAuthor || $isAdmin) { ?>
    <p>Email : <?= $users->getEmail() ?></p>
<?php } ?>

<p>Inscrit depuis le : <?= $users->getDateInscription() ?></p>
<p>Rôle : <?= $users->getRole() ?></p>

<?php if ($isAuthor && $isBan) { ?>
    <p style="color: red;">Vous êtes banni jusqu'au <?= $users->getIsBan() ?>,
        l'accès a certaines fonctionnalités vous est limités
    </p>
<?php } ?>

<?php if ($isAdmin && $isBan) { ?>
    <p style="color: red;">Cet utilisateur est banni jusqu'au <?= $users->getIsBan() ?> et a un accès limité aux fonctionnalités</p>

    <a href="index.php?ctrl=security&action=unbanUser&id=<?= $users->getId() ?>">Déban</a>
<?php } ?>

<form action="index.php?ctrl=security&action=banUser&id=<?= $users->getId() ?>" method="post">
    <input type="date" name="isBan" required>
    <input type="submit" name="banUser">
</form>


<h2>Dernier posts</h2>
<?php if (empty($posts) && $isAuthor) { ?>
    <p>Vous n'avez pas encore posté de message</p>
<?php } else { ?>
    <?php foreach ($posts as $post) { ?>
        <div>
            <p><?= $post->getTexte() ?></p>
            <p>Posté le : <?= $post->getDateCreation() ?></p>
            <p>Par : <?= $users->getPseudo() ?></p>

            <?php if ($isAuthor || $isAdmin) { ?>
                <form action="index.php?ctrl=forum&action=profil" method="post"></form>
                <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>">Supprimer</a>
            <?php } ?>
        </div>
    <?php } ?>
<?php } ?>
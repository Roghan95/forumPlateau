<?php
$users = $result["data"]["user"];
$isAuthor = (isset($_SESSION["user"]) && ($_SESSION["user"]->getId() == $user->getId()));
$isAdmin = App\Session::isAdmin();
?>
<h1>Profil</h1>
<figure>
    <p><img src="https://picsum.photos/50/50" alt="Photo de profil"></p>
    <p>Pseudo : <?= $user->getPseudo() ?></p>
</figure>
<p>Email : <?= $user->getEmail() ?></p>
<p>Vous êtes inscris depuis le : <?= $user->getDateInscription() ?></p>
<p>Rôle : <?= $user->getRole() ?></p>


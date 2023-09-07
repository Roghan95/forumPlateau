<?php
$users = $result["data"]['users'];
?>

<h1>S'enregistrer</h1>

<form action="index.php?ctrl=security&action=register" method="post">
    <label for="pseudo">Pseudo</label>
    <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo" required>

    <label for="email">Email</label>
    <input type="email" name="email" placeholder="Email" required>

    <label for="mdp">Mot de passe</label>
    <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required>

    <label for="mdpConfirm">Confirmer le mot de passe</label>
    <input type="password" name="mdpConfirm" id="mdpConfirm" placeholder="Confirmer le mot de passe" required>

    <input type="submit" name="register" value="S'inscrire">
</form>
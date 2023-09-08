<?php
?>

<h1>S'enregistrer</h1>

<form action="index.php?ctrl=security&action=register" method="post">
    <label for="pseudo">Pseudo : *</label>
    <input type="text" name="pseudo" id="pseudo" required>

    <label for="email">Email * </label>
    <input type="email" name="email" id="email" required>

    <label for="mdp">Mot de passe *</label>
    <input type="password" name="mdp" id="mdp" required>

    <label for="mdpConfirm">Confirmer le mot de passe *</label>
    <input type="password" name="mdpConfirm" id="mdpConfirm" required>

    <input type="submit" name="register" value="S'inscrire">
</form>
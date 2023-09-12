<?php
?>

<h1>S'enregistrer</h1>

<form class="register-form" action="index.php?ctrl=security&action=register" method="post">
    <label for="pseudo">Pseudo *:</label>
    <input class="input-pseudo" type="text" name="pseudo" id="pseudo" required>

    <label for="email">Email *:</label>
    <input class="input-email" type="email" name="email" id="email" required>

    <label for="mdp">Mot de passe *:</label>
    <input class="input-pass" type="password" name="mdp" id="mdp" required>

    <label for="mdpConfirm">Confirmer le mot de passe *:</label>
    <input class="input-pass" type="password" name="mdpConfirm" id="mdpConfirm" required>

    <input class="submit" type="submit" name="register" value="S'inscrire">
    <p>Vous avez déjà un compte ? <a href="index.php?ctrl=security&action=login" style="color:#3C5BFF; padding-top:20px;">Connectez-vous.</a></p>
</form>
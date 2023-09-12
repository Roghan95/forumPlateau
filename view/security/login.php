<h1>Se connecter</h1>

<form class="login-form" action="index.php?ctrl=security&action=login" method="post">
    <label for="email">Email *:</label>
    <input class="input-email" type="email" name="email" id="email" required>

    <label for="mdp">Mot de passe *:</label>
    <input class="input-pass" type="password" name="mdp" id="mdp" required>

    <input class="submit" type="submit" name="login" value="Connection">
    <p>Vous n'avez pas de compte ? <a href=" index.php?ctrl=security&action=register" style="color: #3C5BFF;">Crée un compte</a>.</p>
</form>
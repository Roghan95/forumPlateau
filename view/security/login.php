<h1>Se connecter</h1>

<form action="index.php?ctrl=security&action=login" method="post">
    <label for="email">Email *:</label>
    <input type="email" name="email" id="email" required>

    <label for="mdp">Mot de passe *:</label>
    <input type="password" name="mdp" id="mdp" required>

    <input type="submit" name="login" value="Connection">
</form>
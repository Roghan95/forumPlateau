<form class="register-form" action="index.php?ctrl=security&action=register" method="post">

    <label for="">
        Pseudo:
        <input type="text" name="pseudo" required>
    </label>

    <label for="">
        Email:
        <input type="email" name="email" required>
    </label>

    <label for="">
        Mot de passe:
        <input type="password" name="mdp" required>
    </label>

    <label for="">
        Confirmer le mot de passe:
        <input type="password" name="confirmMdp" required>
    </label>

    <input type="submit" name="register" value="S'inscrire">

</form>
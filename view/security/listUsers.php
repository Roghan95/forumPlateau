<?php
$users = $result["data"]['users'];

?>

<table class="usersTable" border=1>
    <tr>
        <th>Pseudo</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>Date d'Inscription</th>
        <th>Jusqu'au</th>
    </tr>
    <?php foreach ($users as $user) { ?>
        <tr>
            <td>
                <a href="index.php?ctrl=security&action=profil"><?= $user->getPseudo() ?></a>
            </td>
            <td>
                <p><?= $user->getEmail() ?></p>
            </td>

            <td>
                <p><?= $user->getRole() ?></p>
            </td>
            <td>
                <p><?= $user->getDateInscription() ?></p>
            </td>
            <td>
                <?php if ($user->getIsBan() == null) {  ?>
                    <bouton>Bannir</bouton>
                    <form action="">
                        <input type="date" name="dateBan">
                        <input type="submit" name="ban" value="Bannir">
                    </form>
                <?php } else { ?>
                    <p><?= $user->getIsBan() ?></p>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>
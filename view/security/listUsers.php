<?php
$users = $result["data"]['users'];

?>

<table class="usersTable" border=1 style="padding: 10px;">
    <tr>
        <th>Pseudo</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>Date d'Inscription</th>
        <th>Jusqu'au</th>
    </tr>
    <?php foreach ($users as $user) {
        if (!($user->getRole() == "ROLE_ADMIN")) { ?>

            <tr>
                <td>
                    <a href="index.php?ctrl=forum&action=profil&id=<?= $user->getId() ?>"><?= $user->getPseudo() ?></a>
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
                        <!-- <button style="background-color:red; border:none; border-radius:7px; padding: 5px 15px 5px 15px; color:white; cursor:pointer;">Bannir</button> -->
                        <form action="index.php?ctrl=security&action=banUser&id=<?= $user->getId() ?>">
                            <input type="date" name="dateBan">
                            <input type="submit" name="banUser" value="Bannir">
                        </form>
                    <?php } else { ?>
                        <p style="color:red;">L'utilisateur est banni jusqu'au : <?= $user->getIsBan() ?></p>
                        <form action="index.php?ctrl=security&action=unbanUser&id=<?= $user->getId() ?>">
                            <input style="background-color:green; border:none; border-radius:7px; padding: 5px 15px 5px 15px; color:white; cursor:pointer;" type="submit" name="unbanUser" value="Débannir">
                        </form>
                    <?php } ?>
                </td>
            </tr>
    <?php }
    } ?>
</table>
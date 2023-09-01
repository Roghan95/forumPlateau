<?php
$categories = $result["data"]['categories'];
?>


<div class="container">
    <h1>FORUM</h1>
    <div class="categorie">
        <div class="box">
            <?php foreach ($categories as $categorie) { ?>
                <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $categorie->getId() ?>">
                    <p><?= $categorie->getNomCategorie() ?></p>
                </a>
                <input type="text" id="moninput" value="" onKeyUp="afficher_span(event, this.value);" style="display:none;" />
                <span id="monspan" onclick="afficher_input(this)">Coucou</span>

                <script type="text/javascript">
                    function afficher_span(evenement, t) {
                        var touche = window.event ? evenement.keyCode : evenement.which;
                        if (touche == 13) {
                            document.getElementById('moninput').style.display = 'none';
                            document.getElementById('monspan').style.display = '';
                            document.getElementById('monspan').innerHTML = t;
                        }
                    }

                    function afficher_input(t) {
                        document.getElementById('moninput').style.display = '';
                        document.getElementById('monspan').style.display = 'none';
                        document.getElementById('moninput').value = t.innerHTML;
                    }
                </script>
                <script></script>
            <?php } ?>
        </div>
    </div>
</div>
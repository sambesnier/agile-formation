<h1> Page d'accueil du Cyber Café </h1>

<ul class="list-group">

    <div class="list-group">
        <?php foreach ($listPC as $item): ?>
            <?php if ($item['libre'] == 0){
                $color = "green";
                $state = "";
            } else {
                $color = "red";
                $state = "disabled";
            }

        ?>

            <a href="index.php?controller=reservation&id=<?=$item['id_pc']?>" class="list-group-item <?=$state?>">
                <h3 class="list-group-item-heading"><?= $item["nom"]?></h3>

                <i class="material-icons" style="font-size:48px; color: <?=$color?>">laptop_windows</i>
                <?php if ($color=="red"):?>
                    <p>Fin à <?=$listDate[$item['id_pc']] ?></p>
                <?php else :?>
                    <p>Libre</p>
                <?php endif ?>
            </a>
        <?php endforeach; ?>
    </div>

</ul>

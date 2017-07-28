<h1> Page d'accueil du Cyber Café </h1>

<ul class="list-group">

    <div class="well">
        <?php $counter = 0; ?>
        <?php foreach ($listPC as $item): ?>
            <?php if ($item['libre'] == 0){
                $color = "green";
                $state = "";
            } else {
                $color = "red";
                $state = "disabled";
            }

?>

            <?php if ($counter == 0) : ?>
                <div class="row" style="margin-bottom: 10px;">
            <?php endif; ?>
            <div class="col-md-4">
                <a href="index.php?controller=reservation&id=<?=$item['id_pc']?>" class="list-group-item <?=$state?>">
                    <h3 class="list-group-item-heading"><?= $item["nom"] ?></h3>
                    <i class="material-icons" style="font-size:48px; color: <?=$color?>">laptop_windows</i>
                    <?php if ($color=="red"):?>
                        <p>Fin à <?=$listDate[$item['id_pc']] ?></p>
                    <?php else :?>
                        <p>Libre</p>
                    <?php endif ?>
                </a>
            </div>
            <?php $counter++; ?>
            <?php if ($counter > 2) {
                $counter = 0;
            }
            ?>
            <?php if ($counter == 0) : ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

</ul>

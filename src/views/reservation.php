<h1>Page de réservation</h1>

<?= $now ?>

<form method="post">
    <div class="form-group">
        <label for="beginTime">Heure de début :</label>
        <br>
        <label><?=$time?></label>
    </div>
    <div class="form-group">
        <label for="endTime">Heure de fin</label>
        <input type="time" class="form-control" name="endTime" step="900" value=<?=$time?> min="<?=$time?>" max="<?=$maxTime?>">
    </div>

    <h3>Vous avez un crédit de <?=$credit?> €</h3>
    <button type="submit" name="submit" class="btn btn-default">Réserver</button>
</form>

<!--Afficher les erreurs éventuelles-->
<?php if (count($error) > 0): ?>
    <div class="alert alert-danger col-md-4">
        <ul>
            <?php foreach($error as $item) :?>
                <li> <?=$item?> </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
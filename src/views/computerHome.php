<h1>Page de réservation</h1>

<ul class="list-group">

    <div class="well">

        <div class="row">
            <?php for ($j = 1; $j < count($listPC); $j++) : ?>
            <div class="col-md-1">
                <div class="head-pc">
                    <h3>PC<?= $j ?></h3>
                    <i class="material-icons" style="font-size:48px;">laptop_windows</i>
                </div>
                <form method="post">
                <?php for ($i = 0; $i < 39; $i++) : ?>
                    <?php $checked = empty($heures[$i]['checked'])?"":"checked"; ?>
                    <?php $class = empty($heures[$i]['checked'])?"libre":"occupe"; ?>
                    <?php $alreadyChecked =  !empty($heures[$i]['checked'])?"":"name=\"heure-$i\""; ?>
                    <div class="heure <?= $class ?>"><?= $heures[$i]['debut'] ?><input <?= $alreadyChecked ?> type="checkbox" <?= $checked ?>></div>
                <?php endfor; ?>
                <button type="submit" name="submit-<?= $j ?>" class="btn btn-primary">OK</button>
                </form>
            </div>
            <?php endfor; ?>
        </div>
    </div>

</ul>

<style>

    td {
        border: none!important;
        padding: 5px!important;
        vertical-align: middle!important;
    }

    .occupe {
        background-color: red!important;
    }

    .libre {
        background-color: lightblue;
    }

    .selected {
        background-color: lightgreen!important;
    }

    .heure {
        margin-bottom: 5px;
        background-color: lightblue;
        padding: 10px;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
    }

    .heure:hover {
        box-shadow: 0px 0px 5px black;
    }

    .head-pc {
        margin: auto;
        width: 80%;
    }

    button {
        width: 100%;
    }

    input {
        display: none;
    }

    .midi {
        color: white;
        background-color: black;
    }

</style>
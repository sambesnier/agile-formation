<h1>Page de réservation</h1>

<ul class="list-group">

    <div class="well">

        <div class="row">
            <?php for ($j = 0; $j < count($listPC); $j++) : ?>
            <div class="col-md-1">
                <div class="head-pc">
                    <h3>PC<?= $j+1 ?></h3>
                    <i class="material-icons" style="font-size:48px;">laptop_windows</i>
                </div>
                <form method="post">
                <?php for ($i = 0; $i < 40; $i++) : ?>
                    <?php $checked = empty($listPC[$j]['heures'][$i]['checked'])?"":"checked"; ?>
                    <?php $status = empty($listPC[$j]['heures'][$i]['disabled'])?"":"disabled"; ?>
                    <?php $class = empty($listPC[$j]['heures'][$i]['checked'])?"libre":"occupe"; ?>
                    <?php $alreadyChecked =  !empty($listPC[$j]['heures'][$i]['checked'])?"":"name=\"heure-$i\""; ?>
                    <div class="heure <?= $class ?> <?= $status ?>"><?= $listPC[$j]['heures'][$i]['debut'] ?><input <?= $alreadyChecked ?> type="checkbox" <?= $checked ?>></div>
                <?php endfor; ?>
                <button type="submit" name="submit-<?= $j+1 ?>" class="btn btn-primary">OK</button>
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
        background-color: indianred!important;
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
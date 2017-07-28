<h1>Page de réservation</h1>

<ul class="list-group">

    <div class="well">
        <table class="table">
            <tr>
                <form method="post">
                <td>
                    <h3>PC1</h3>
                    <i class="material-icons" style="font-size:48px;">laptop_windows</i>
                </td>
                    <?php for ($i = 0; $i < 12; $i++) : ?>
                        <?php $checked = empty($heures[$i]['checked'])?"":"checked"; ?>
                        <?php $class = empty($heures[$i]['checked'])?"class=\"libre\"":"class=\"occupe\""; ?>
                        <?php $alreadyChecked =  !empty($heures[$i]['checked'])?"":"name=\"heure-$i\""; ?>
                        <td <?= $class ?>><input <?= $alreadyChecked ?> type="checkbox" <?= $checked ?>></td>
                    <?php endfor; ?>

                <td class="midi">X</td>
                <td class="midi">X</td>

                    <?php for ($i = 12; $i < 39; $i++) : ?>
                        <?php $checked = empty($heures[$i]['checked'])?"":"checked"; ?>
                        <?php $class = empty($heures[$i]['checked'])?"class=\"libre\"":"class=\"occupe\""; ?>
                        <?php $alreadyChecked =  !empty($heures[$i]['checked'])?"":"name=\"heure-$i\""; ?>
                        <td <?= $class ?>><input <?= $alreadyChecked ?> type="checkbox" <?= $checked ?>></td>
                    <?php endfor; ?>

                <td><button type="submit" name="submit-1" class="btn btn-primary">Réservation</button></td>
                </form>
            </tr>
        </table>
    </div>

</ul>

<style>

    td {
        border: none!important;
        padding: 5px!important;
        vertical-align: middle!important;
    }

    .occupe {
        background-color: red;
    }

    .libre {
        background-color: green;
    }

    .midi {
        color: white;
        background-color: black;
    }

</style>
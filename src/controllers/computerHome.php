<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 25/07/2017
 * Time: 09:49
 */

$id_user= $_SESSION['user']['id_user'];

$connexion = getPDO();
$sql = 'SELECT * FROM pcs';
$listPC = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM reservations';
$listReserv = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$listDate = [];

$heures = getCorrespondanceHeures();



for ($k = 0; $k < count($listPC); $k++) {
    $heuresView = [];
    $heuresView = array_values($heures);
    for ($i = 0; $i < count($heuresView); $i++) {
        if (time() > strtotime($heuresView[$i]['debut'])) {
            $heuresView[$i]['checked'] = "checked";
            $heuresView[$i]['disabled'] = "disabled";
        }
    }
    foreach ($listReserv as $item) {
        if (time() > strtotime($item['fin'])){
            $id_PC = $item['id_pc'];

            $sql = 'DELETE FROM reservations WHERE id_pc=:id_pc';
            $param['id_pc'] = $id_PC;
            $stm = $connexion->prepare($sql);
            $stm->execute($param);
        }
        for ($i = 0; $i < count($heuresView); $i++) {
            if ($item['id_pc'] == $k+1) {
                $debutHeures = strtotime($heuresView[$i]['debut']) + 2 * 3600;
                $debutHeures = new DateTime("@$debutHeures");

                $debutItem = strtotime($item['debut']) + 2 * 3600;
                $debutItem = new DateTime("@$debutItem");

                $finHeures = strtotime($heuresView[$i]['fin']) + 2 * 3600;
                $finHeures = new DateTime("@$finHeures");

                $finItem = strtotime($item['fin']) + 2 * 3600;
                $finItem = new DateTime("@$finItem");

                $indiceDebut;
                if ($debutItem == $debutHeures) {
                    $heuresView[$i]['checked'] = "checked";
                    $indiceDebut = $i;
                }
                if ($finItem == $finHeures) {
                    $heuresView[$i]['checked'] = "checked";
                    for ($j = $i; $j > $indiceDebut; $j--) {
                        $heuresView[$j]['checked'] = "checked";
                    }
                }
            }
        }
    }
    $listPC[$k]['heures'] = $heuresView;
}

$indiceSubmit = 0;
for ($i = 1; $i <= 10; $i++) {
    $isSubmitted = filter_has_var(INPUT_POST, 'submit-'.$i);
    if ($isSubmitted) {
        $indiceSubmit = $i;
    }
}


if ($indiceSubmit != 0 && count($_POST) > 1) {
    $minutes = array_keys($_POST);
    //var_dump($minutes[0]);
    //var_dump($minutes[count($minutes)-2]);
    //var_dump("Votre réservation est de ".$heures[$minutes[0]]['debut']." à ".$heures[$minutes[count($minutes)-2]]['fin']);
    $debut = strtotime($heures[$minutes[0]]['debut'])+2*3600;
    $debutDatetime = new DateTime("@$debut");
    $fin = strtotime($heures[$minutes[count($minutes)-2]]['fin'])+2*3600;
    $finDatetime = new DateTime("@$fin");

    $quartDheures = 0;

    for ($i = 0; $i < count($heuresView); $i++) {
            $debutHeures = strtotime($heuresView[$i]['debut']) + 2 * 3600;
            $debutHeures = new DateTime("@$debutHeures");

            $debutItem = $debutDatetime;

            $finHeures = strtotime($heuresView[$i]['fin']) + 2 * 3600;
            $finHeures = new DateTime("@$finHeures");

            $finItem = $finDatetime;

            $indiceDebut;
            if ($debutItem == $debutHeures) {
                $indiceDebut = $i;
            }
            if ($finItem == $finHeures) {
                $quartDheures = $i - $indiceDebut +1;
            }

    }

    var_dump($quartDheures);

    $sql = 'INSERT INTO reservations (debut, fin, id_pc, id_user) VALUES (?,?,?,?)';
    $stm = $connexion->prepare($sql);
    $stm->execute([$debutDatetime->format('Y-m-d H:i:s'),$finDatetime->format('Y-m-d H:i:s'),$indiceSubmit,$id_user]);

    $sql = 'UPDATE users SET credit=credit-:credit WHERE id_user=:id_user';
    $params['id_user'] = $id_user;
    $params['credit'] = 0.75*$quartDheures;
    $stm = $connexion->prepare($sql);
    $stm->execute($params);

    $_SESSION['flash'] = ['success' => 'Votre réservation à été validée'];

    header('Location: index.php?controller=computerHome');
    exit();
}

renderView(
    'computerHome',
    [
        'pageTitle' => 'Bienvenue au Cyber Café',
        'listPC' => $listPC,
        'listDate' => $listDate,
        'heures' => $heuresView
    ]
);

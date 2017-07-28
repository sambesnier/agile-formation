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

$heuresView = array_values($heures);

foreach ($listReserv as $item){
    /*if (time() > strtotime($item['fin'])){
        $id_PC = $item['id_pc'];
        $sql = 'UPDATE pcs SET libre=0 WHERE id_pc=:id_pc';
        $param['id_pc'] = $id_PC;
        $stm = $connexion->prepare($sql);
        $stm->execute($param);

        $sql = 'DELETE FROM reservations WHERE id_pc=:id_pc';
        $stm = $connexion->prepare($sql);
        $stm->execute($param);
    }
    $date = explode(" ",$item['fin']);
    $listDate[$item['id_pc']] = $date[1];*/

    for ($i = 0; $i < count($heuresView); $i++) {
        $debutHeures = strtotime($heuresView[$i]['debut'])+2*3600;
        $debutHeures = new DateTime("@$debutHeures");

        $debutItem = strtotime($item['debut'])+2*3600;
        $debutItem = new DateTime("@$debutItem");

        $finHeures = strtotime($heuresView[$i]['fin'])+2*3600;
        $finHeures = new DateTime("@$finHeures");

        $finItem = strtotime($item['fin'])+2*3600;
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

$isSubmitted = filter_has_var(INPUT_POST, 'submit-1');

if ($isSubmitted) {
    $minutes = array_keys($_POST);
    //var_dump($minutes[0]);
    //var_dump($minutes[count($minutes)-2]);
    //var_dump("Votre réservation est de ".$heures[$minutes[0]]['debut']." à ".$heures[$minutes[count($minutes)-2]]['fin']);
    $debut = strtotime($heures[$minutes[0]]['debut'])+2*3600;
    $debutDatetime = new DateTime("@$debut");
    $fin = strtotime($heures[$minutes[count($minutes)-2]]['fin'])+2*3600;
    $finDatetime = new DateTime("@$fin");

    $sql = 'INSERT INTO reservations (debut, fin, id_pc, id_user) VALUES (?,?,?,?)';
    $stm = $connexion->prepare($sql);
    $stm->execute([$debutDatetime->format('Y-m-d H:i:s'),$finDatetime->format('Y-m-d H:i:s'),1,$id_user]);

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
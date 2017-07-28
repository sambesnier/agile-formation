<?php

$id_user= $_SESSION['user']['id_user'];

$id_pc = filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT);
$connexion = getPDO();
$sql = 'SELECT * FROM users WHERE id_user=:id_user';
$param['id_user'] = $id_user;
$stm = $connexion->prepare($sql);
$stm->execute($param);
$user = $stm->fetch(PDO::FETCH_ASSOC);

setlocale(LC_TIME,'fra_fra');
$actualDate = new DateTime();
$actualTimestamp = time();
$midiTimestamp = mktime(12,0,0);
$soirTimestamp = mktime(21,0,0);
$maxTimeWithCredit = $actualTimestamp + intval(($user['credit']*3600/3));

if ($actualTimestamp<$midiTimestamp){
    //Période du matin
    $maxTime = min($midiTimestamp, $maxTimeWithCredit);
} else {
    //Période de l'après-midi
    $maxTime = min($soirTimestamp, $maxTimeWithCredit);
}

$maxDate = date('H:i', $maxTime);

//Traitement du formulaire
$isSubmitted = filter_has_var(INPUT_POST, 'submit');
$error = [];
if ($isSubmitted){
    $end = filter_input(INPUT_POST, 'endTime');

    if (strtotime($end)<$actualTimestamp){
        $error[] = "Vous devez saisir une heure de fin supérieure à celle de début";
    }
    if (count($error)==0){
        $h = strtotime($end)+2*3600;
        $endDate = new DateTime("@$h");

        $sql = 'INSERT INTO reservations (debut, fin, id_pc, id_user) VALUES (?,?,?,?)';
        $stm = $connexion->prepare($sql);
        $stm->execute([$actualDate->format('Y-m-d H:i:s'),$endDate->format('Y-m-d H:i:s'),$id_pc,$id_user]);

        $sql = 'UPDATE users SET credit=:credit WHERE id_user=:id_user';
        $params['id_user'] = $id_user;
        $params['credit'] = $user['credit']-(strtotime($end)-$actualTimestamp)/3600*3;
        $stm = $connexion->prepare($sql);
        $stm->execute($params);

        $sql = 'UPDATE pcs SET libre=1 WHERE id_pc =:id';
        $para["id"] = $id_pc;
        $stm = $connexion->prepare($sql);
        $stm->execute($para);


        header("location:index.php?controller=computerHome");
    }

}



renderView(
    'reservation',
    [
        'pageTitle' => 'Page de réservation',
        'now' => strftime('%A %d %B %Y'),
        'time' => strftime('%H:%M'),
        'maxTime' => $maxDate,
        'credit' => $user['credit'],
        'error' => $error

    ]
);
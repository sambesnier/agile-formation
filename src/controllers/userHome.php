<?php


$connexion = getPDO();
$id_user = $_SESSION['user']['id_user'];
$credit = $_SESSION['user']['credit'];
$newsletter = $_SESSION['user']['newsletter'];

$id_resa = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

$sql = 'SELECT * FROM reservations WHERE id_user =?';
$stm = $connexion->prepare($sql);
$stm->execute([$id_user]);
$listReserv = $stm->fetchAll(PDO::FETCH_ASSOC);


//Traitement du lien "annuler" sélectionné
if ($id_resa) {

    //Mise à jour des PCs réservés
    $sql = 'UPDATE pcs SET libre=0 WHERE id_pc=:id_pc';
    $param['id_pc'] = $listReserv[0]['id_pc'];
    $stm = $connexion->prepare($sql);
    $stm->execute($param);

    //Mise à jour crédit utilisateur (remboursement)
    list($date,$time)=explode(' ',$listReserv[0]['debut']);
    list($hours, $minutes, $seconds)=explode(':',$time);
    $minDebut = $hours * 60 + $minutes;


    list($date,$time)=explode(' ',$listReserv[0]['fin']);
    list($hours, $minutes,$seconds)=explode(':',$time);
    $minFin = $hours * 60 + $minutes;
    $remboursement = ($minFin - $minDebut) / 20;        // *3 / 60

    $credit += $remboursement;
    //var_dump($credit);exit();

    $sql = 'UPDATE users SET credit=:credit WHERE id_user=:id_user';
    $para['id_user'] = $id_user;
    $para['credit'] = $credit;
    $stm = $connexion->prepare($sql);
    $stm->execute($para);

    //Suppression de la réservation
    $stm = $connexion->prepare('DELETE FROM reservations WHERE id_resa=:id_resa');
    $stm->bindParam('id_resa', $id_resa);
    $stm->execute();

    //Mise à jour session utilisateur
    $_SESSION['user']['credit'] = $credit;

    //Redirection vers page userHome
    header('Location: index.php?controller=userHome');
}

//Traitement du formulaire Info
$isSubmittedInfo = filter_has_var(INPUT_POST, 'submitInfo');
if ($isSubmittedInfo) {
    $nom = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);

    //Mise à jour des nouvelles informations dans la base de données
    $sql = "UPDATE users SET nom=:nom, prenom=:prenom, telephone=:telephone WHERE id_user=:id_user";
    $params['id_user'] = $id_user;
    $params['nom'] = $nom;
    $params['prenom'] = $prenom;
    $params['telephone'] = $telephone;
    $stm = $connexion->prepare($sql);
    $stm->execute($params);

    $_SESSION['user']['nom'] = $nom;
    $_SESSION['user']['prenom'] = $prenom;
    $_SESSION['user']['telephone'] = $telephone;
}

//Traitement du formulaire Annuler


//Traitement du formulaire Newsletter
$isSubmittedLetter = filter_has_var(INPUT_POST, 'submitLetter');

if ($isSubmittedLetter) {
    if ($newsletter == "O") {
        $newsletter = "N";
    } else {
        $newsletter = "O";
    }

    $sql = "UPDATE users SET newsletter=:newsletter WHERE id_user=:id_user";
    $param['id_user'] = $id_user;
    $param['newsletter'] = $newsletter;
    $stm = $connexion->prepare($sql);
    $stm->execute($param);

    $_SESSION['user']['newsletter'] = $newsletter;

}


renderView(
    'userHome',
    [
        'pageTitle' => 'Espace client',
        'listReserv' => $listReserv
    ]
);
<?php


$connexion = getPDO();
$id_user = $_SESSION['user']['id_user'];
$newsletter = $_SESSION['user']['newsletter'];

//Traitement du formulaire Info
$isSubmittedInfo = filter_has_var(INPUT_POST, 'submitInfo');
if ($isSubmittedInfo){
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


//Traitement du formulaire Newsletter
$isSubmittedLetter = filter_has_var(INPUT_POST, 'submitLetter');

if ($isSubmittedLetter){
    if ($newsletter == "O"){
        $newsletter ="N";
    }
    else{
        $newsletter = "O";
    }

    $sql = "UPDATE users SET newsletter=:newsletter WHERE id_user=:id_user";
    $param['id_user']=$id_user;
    $param['newsletter'] = $newsletter;
    $stm = $connexion->prepare($sql);
    $stm->execute($param);

    $_SESSION['user']['newsletter'] = $newsletter;

}



renderView(
    'userHome',
    [
        'pageTitle' => 'Espace client'
    ]
);
<?php

$email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);

$connexion = getPDO();
$sql = 'UPDATE users SET confirm="O" WHERE email=:email';
$param["email"] = $email;
$stm = $connexion->prepare($sql);
$stm->execute($param);

$_SESSION['flash'] = ["success" => "Vous êtes maintenant inscrit"];
header('Location: index.php?controller=accueil');
exit();

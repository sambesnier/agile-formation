<?php
/**
 * Created by PhpStorm.
 * User: Samuel Besnier
 * Date: 25/07/2017
 * Time: 16:26
 */

$connexion = getPDO();

//Initialisation des erreurs
$errors=[];
//Récupération des données
$email = filter_input(INPUT_POST,"login",FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);
$isSubmitted = filter_has_var(INPUT_POST,"submit");
if ($isSubmitted){
    //Validation des données
    if (empty ($email)){
        $errors[]= "Vous devez saisir votre identifiant";
    }
    if (empty($password)){
        $errors[]="Vous devez saisir un mot de passe";
    }
    //Traitement des données
    //S'il n'y a pas d'erreurs
    if (count($errors)==0) {
        //Connexion à la base de données pour vérifier l'authentification
        $crytedpassword=sha1($password);

        $query = $connexion->prepare("SELECT * FROM users WHERE email=:email AND password=:password");
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password',$crytedpassword , PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            serializeUser($result);
            $role = $result['role'];
            if($role == 'ADMIN'){
                header("Location: index.php?controller=adminHome");
                exit();
            }else{

                header("Location: index.php?controller=accueil");

                exit();
            }
        } else {
            $_SESSION['flash'] = ["danger" => "Données de connexions invalides"];
        }
    }
}

renderView(
    'connexion',
    [
        'pageTitle' => 'Bienvenue au Cyber Café',
        'errors' => $errors
    ]
);
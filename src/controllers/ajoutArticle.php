<?php
/**
 * Created by PhpStorm.
 * User: E4gleKnight
 * Date: 26/07/2017
 * Time: 15:31
 */


$pdo = getPDO();
if ($_SESSION['user']['role'] != 'ADMIN') {
    $_SESSION['flash'] = ['danger' => "Vous n'avez pas les droits pour accéder à cette page"];
    header('Location: index.php?controller=connexion');
    exit();
}

//Initialisation des erreurs
$errors=[];
//Récupération des données
$Title = filter_input(INPUT_POST,"Titre",FILTER_SANITIZE_STRING);
$Article = filter_input(INPUT_POST,"article",FILTER_SANITIZE_STRING);
$isSubmitted = filter_has_var(INPUT_POST,"submit");
if ($isSubmitted){
    //Validation des données
    if (empty ($Title)){
        $errors[]= "Vous devez saisir le titre";
    }
    if (empty($Article)){
        $errors[]="Vous devez saisir l 'article";
    }
    if (empty($errors)) {
        $sql = $pdo->prepare("INSERT INTO articles (titre, texte) VALUES (:Titre, :Article)");
        $sql->bindParam(':Titre', $Title);
        $sql->bindParam(':Article', $Article);
        try {
            $sql->execute();
            $_SESSION['flash'] = ["success" => "l'article a bien était ajouté"];
            header('Location: index.php?controller=accueil');
            exit();
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l 'enregistrement de l'Article";
        }
    }

}

renderView(
    'ajoutArticle',
[
    'pageTitle' =>'ajoutArticle',
    'errors' => $errors
]
);


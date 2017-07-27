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

renderView(
    'ajoutArticle',
[
    'pageTitle' =>'ajoutArticle'
]
);


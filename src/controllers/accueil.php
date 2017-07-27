<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 26/07/2017
 * Time: 09:54
 */
$pdo= getPDO();
$sql = $pdo->prepare('select * from articles order by id_article desc');
try {
    $sql->execute();
    $articles = $sql->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

}

renderView(
    'accueil',
    [
        'pageTitle' => 'Bienvenue au Cyber Café',
        'articles'=> $articles
    ]
);
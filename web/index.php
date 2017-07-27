
<?php
//Démarrage de la session
session_start();

//Définition du dossier racine du projet
define("ROOT_PATH", dirname(__DIR__));


//Inclusion des dépendances du projet
require ROOT_PATH . '/src/framework/mvc.php';
require ROOT_PATH.'/src/config/config.php';


//Récupération du contrôleur
//avec gestion de la page de défaut
if(isset($_GET["controller"])){
    $controllerName = $_GET["controller"];
} else {
    $controllerName = "computerHome";
}


//Définition du chemin du contrôleur
$controllerPath = ROOT_PATH.'/src/controllers/'. $controllerName.'.php';




//Exécution du contrôleur
require $controllerPath;
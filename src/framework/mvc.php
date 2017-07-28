<?php


/**
 *@param string $view : le nom de la vue
 *@param array $data : un tableau des données passées à la vue
 *@return string le code html de la vue
 */
function getTemplate(string $view, array $data=[]){
    //mise en tampon du résultat de l'interprétation PHP
    //N'envoie pas de réponse HTTP implicite
    ob_start();

    //transformation du tableau associatif des données en une suite de variables
    extract($data);

    //Inclusion de fichier de la vue dans le tampon
    require ROOT_PATH."/src/views/{$view}.php";
    //Récupération du contenu du tampon dans une variable
    $content = ob_get_clean();

    return $content;
}

/**
 *Affiche le résultat d'une vue décorée par un gabarit
 *@param string $view : le nom de la vue
 *@param array $data : un tableau associatif des données passées à la vue
 *@param string $layout : le gabarit qui décorera la vue
 */
function renderView(string $view,
                    array $data=[],
                    string $layout = "gabarit"){
    //récupération du code html(interpolé) de la vue
    $viewContent = getTemplate($view, $data);

    //Ajout du rendu de la vue aux données passées au gabarit
    $data["content"]=$viewContent;

    //Application du gabarit
    $result = getTemplate($layout, $data);

    echo $result;
}

/**
 *Fonction de connexion à une base de données avec la bibliothèque PDO
 *@return PDO
 */
function getPDO(){
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    return new PDO(DSN,DB_USER,DB_PASS, $options);
}

/**
 * Fonction d'autochargement des classes
 * Utilisée par spl_autoload_register
 * @param $className
 * @throws Exception
 */
function autoloader($className){
    $path = ROOT_PATH."/src/classes/{$className}.php";
    if (file_exists($path)){
        require_once $path;
    }else {
        throw new Exception("Le fichier $path ne peut être chargé");
    }
}

function serializeUser(array $infos) {
    $user = [
        'nom' => $infos['nom'],
        'prenom' => $infos['prenom'],
        'email' => $infos['email'],
        'role' =>  $infos['role'],
        'id_user' => $infos['id_user'],
        'credit' => $infos['credit'],
        'telephone' => $infos['telephone'],
        'newsletter' => $infos['newsletter']
    ];

    $_SESSION['user'] = $user;
}

function logoutUser() {
    unset($_SESSION['user']);
    header('Location: index.php?controller=accueil');
    exit();
}

/**
 * Retourne l'utilisateur authentifié
 * @return User
 */
function getUser(){
    if (isset($_SESSION["user"])){
        $user = unserialize($_SESSION["user"]);
    }else {
        $user = new User();
        //Utilisateur par défaut
        $user->setUserName("Invité")->setRole("GUEST");
        $_SESSION["user"]= serialize($user);
    }
    return  $user;
}

function getCorrespondanceHeures() {
    $heures = [
        'heure-0' => [
            'debut' => '9:00',
            'fin' => '9:15'
        ],
        'heure-1' => [
            'debut' => '9:15',
            'fin' => '9:30'
        ],
        'heure-2' => [
            'debut' => '9:30',
            'fin' => '9:45'
        ],
        'heure-3' => [
            'debut' => '9:45',
            'fin' => '10:00'
        ],
        'heure-4' => [
            'debut' => '10:00',
            'fin' => '10:15'
        ],
        'heure-5' => [
            'debut' => '10:15',
            'fin' => '10:30'
        ],
        'heure-6' => [
            'debut' => '10:30',
            'fin' => '10:45'
        ],
        'heure-7' => [
            'debut' => '10:45',
            'fin' => '11:00'
        ],
        'heure-8' => [
            'debut' => '11:00',
            'fin' => '11:15'
        ],
        'heure-9' => [
            'debut' => '11:15',
            'fin' => '11:30'
        ],
        'heure-10' => [
            'debut' => '11:30',
            'fin' => '11:45'
        ],
        'heure-11' => [
            'debut' => '11:45',
            'fin' => '12:00'
        ],
        'heure-12' => [
            'debut' => '14:00',
            'fin' => '14:15'
        ],
        'heure-13' => [
            'debut' => '14:15',
            'fin' => '14:30'
        ],
        'heure-14' => [
            'debut' => '14:30',
            'fin' => '14:45'
        ],
        'heure-15' => [
            'debut' => '14:45',
            'fin' => '15:00'
        ],
        'heure-16' => [
            'debut' => '15:00',
            'fin' => '15:15'
        ],
        'heure-17' => [
            'debut' => '15:15',
            'fin' => '15:30'
        ],
        'heure-18' => [
            'debut' => '15:30',
            'fin' => '15:45'
        ],
        'heure-19' => [
            'debut' => '15:45',
            'fin' => '16:00'
        ],
        'heure-20' => [
            'debut' => '16:00',
            'fin' => '16:15'
        ],
        'heure-21' => [
            'debut' => '16:15',
            'fin' => '16:30'
        ],
        'heure-22' => [
            'debut' => '16:30',
            'fin' => '16:45'
        ],
        'heure-23' => [
            'debut' => '16:45',
            'fin' => '17:00'
        ],
        'heure-24' => [
            'debut' => '17:00',
            'fin' => '17:15'
        ],
        'heure-25' => [
            'debut' => '17:15',
            'fin' => '17:30'
        ],
        'heure-26' => [
            'debut' => '17:30',
            'fin' => '17:45'
        ],
        'heure-27' => [
            'debut' => '17:45',
            'fin' => '18:00'
        ],
        'heure-28' => [
            'debut' => '18:00',
            'fin' => '18:15'
        ],
        'heure-29' => [
            'debut' => '18:15',
            'fin' => '18:30'
        ],
        'heure-30' => [
            'debut' => '18:30',
            'fin' => '18:45'
        ],
        'heure-31' => [
            'debut' => '19:00',
            'fin' => '19:15'
        ],
        'heure-32' => [
            'debut' => '19:15',
            'fin' => '19:30'
        ],
        'heure-33' => [
            'debut' => '19:30',
            'fin' => '19:45'
        ],
        'heure-34' => [
            'debut' => '19:45',
            'fin' => '20:00'
        ],
        'heure-35' => [
            'debut' => '20:00',
            'fin' => '20:15'
        ],
        'heure-36' => [
            'debut' => '20:15',
            'fin' => '20:30'
        ],
        'heure-37' => [
            'debut' => '20:30',
            'fin' => '20:45'
        ],
        'heure-38' => [
            'debut' => '20:45',
            'fin' => '21:00'
        ],
    ];
    return $heures;
}

?>

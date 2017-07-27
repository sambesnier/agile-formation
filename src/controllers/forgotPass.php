<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 26/07/2017
 * Time: 18:20
 */

$pdo = getPDO();

$errors = [];

$isSubmitted = filter_has_var(INPUT_POST, 'submit');

if ($isSubmitted) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (empty($email)) {
        $errors[] = "Vous devez entrer un email valide";
    }
    $sql = $pdo->prepare('SELECT password FROM users WHERE email=:email');
    $sql->bindParam(':email', $email);

    try {
        $sql->execute();
        $rs = $sql->fetch(PDO::FETCH_ASSOC);
        if (!$rs) {
            $errors[] = "L'utilisateur n'existe pas dans la base de données";
        } else {
            $pass = $rs['password'];
            $key = [
                'email' => $email,
                'pass' => sha1($pass)
            ];
            $keyJson = json_encode($key);
            $keyCrypted = base64_encode($keyJson);
            $url = 'http://localhost/index.php?controller=resetPassword&key='.$keyCrypted;

            // TODO: Implémenter la méthode d'envoi de mails

            $_SESSION['flash'] = ['success' => 'Un lien pour réinitialiser votre email vous a été envoyé par mail'];
        }
    } catch (PDOException $e) {
        $errors[] = "Erreur de requête SQL";
    }
}

renderView(
    'forgotPass',
    [
        'pageTitle' => 'Mot de passe oublié',
        'errors' => $errors
    ]
);
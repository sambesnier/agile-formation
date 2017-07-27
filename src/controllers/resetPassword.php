<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 26/07/2017
 * Time: 18:49
 */

$pdo = getPDO();

$errors = [];

$isSubmitted = filter_has_var(INPUT_POST, 'submit');

$key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);

$keyDecoded = base64_decode($key);

$keyJson = json_decode($keyDecoded, true);

$email = $keyJson['email'];

if ($isSubmitted) {
    $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $confirm = filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_STRING);

    if ($pass != $confirm) {
        $errors[] = "Les mots de passe doivent correspondre";
    }
    if (empty($pass)) {
        $errors[] = "Vous devez saisir un mot de passe";
    }
    if (empty($errors)) {
        $passCrypted = sha1($pass);
        $sql = $pdo->prepare('UPDATE users SET password=:password WHERE email=:email');
        $sql->bindParam(':password', $passCrypted);
        $sql->bindParam(':email', $email);
        try {
            $sql->execute();
            $_SESSION['flash'] = ["success" => "Mot de passe réinitialisé avec succès"];
            header('Location: index.php?controller=accueil');
            exit();
        } catch (PDOException $e) {
            $errors[] = "Impossible de réinitialiser le mot de passe";
        }
    }
} else {
    $pass = $keyJson['pass'];

    $sql = $pdo->prepare('SELECT password FROM users WHERE email=:email');
    $sql->bindParam(':email', $email);

    try {
        $sql->execute();
        $rs = $sql->fetch(PDO::FETCH_ASSOC);
        if (!$rs || sha1($rs['password']) != $pass) {
            $_SESSION['flash'] = ["danger" => "Impossible de trouver l'utilisateur"];
            header('Location: index.php?controller=accueil');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['flash'] = ["danger" => "Impossbile de trouver l'utilisateur"];
        header('Location: index.php?controller=accueil');
        exit();
    }
}

renderView(
    'resetPassword',
    [
        'pageTitle' => 'Réinitialisation du mot de passe',
        'errors' => $errors
    ]
);
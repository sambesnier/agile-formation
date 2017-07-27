<?php
/**
 * Created by PhpStorm.
 * User: Samuel Besnier
 * Date: 26/07/2017
 * Time: 10:27
 */

$pdo = getPDO();

if ($_SESSION['user']['role'] != 'ADMIN') {
    $_SESSION['flash'] = ['danger' => "Vous n'avez pas les droits pour accéder à cette page"];
    header('Location: index.php?controller=connexion');
    exit();
}

$errors = [];

$sql = 'SELECT * FROM pcs';
$listPC = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM users ORDER BY nom';
$users = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$isSubmitted = filter_has_var(INPUT_POST, 'submit');
if ($isSubmitted) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $role = $_POST['role'];
    if ($role == '-') {
        $errors[] = "Vous devez choisir un rôle";
    }
    if (empty($email)) {
        $errors[] = "Vous devez saisir un email";
    }

    if (empty($errors)) {

        $sql = $pdo->prepare("UPDATE users SET role=:role WHERE email=:email");
        $sql->bindParam(':email', $email);
        $sql->bindParam(':role', $role);
        try {
            $sql->execute();
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de la modification du rôle";
        }

        $_SESSION['flash'] = ["success" => "Rôle modifié"];
        header('Location: index.php?controller=adminHome');
        exit();
    }
}

$isSubmittedCredit = filter_has_var(INPUT_POST, 'submitCredit');
if ($isSubmittedCredit){
    $email = filter_input(INPUT_POST, 'emailCredit', FILTER_SANITIZE_EMAIL);
    $credit = $_POST['credit'];
    if ($credit == ""){
        $errors[] = "Vous devez choisir votre nouveau crédit";
    }
    if (empty($email)) {
        $errors[] = "Vous devez saisir un email";
    }
    if (empty($errors)){
        $sql = $pdo->prepare("UPDATE users SET credit=:credit WHERE email=:email");
        $sql->bindParam(':email', $email);
        $sql->bindParam(':credit', $credit);
        try {
            $sql->execute();
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de la modification du crédit";
        }

        $_SESSION['flash'] = ["success" => "Crédit modifié"];
        header('Location: index.php?controller=adminHome');
        exit();
    }
}

renderView(
    'adminHome',
    [
        'pageTitle' => 'Administration',
        'errors' => $errors,
        'users' => $users,
        'listPC' => $listPC
    ]
);
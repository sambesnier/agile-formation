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

$sql = 'SELECT * FROM reservations';
$listReserv = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$listDate = [];
foreach ($listReserv as $item){
    if (time() > strtotime($item['fin'])){
        $id_PC = $item['id_pc'];
        $sql = 'UPDATE pcs SET libre=0 WHERE id_pc=:id_pc';
        $param['id_pc'] = $id_PC;
        $stm = $pdo->prepare($sql);
        $stm->execute($param);

        $sql = 'DELETE FROM reservations WHERE id_pc=:id_pc';
        $stm = $pdo->prepare($sql);
        $stm->execute($param);
    }
    $date = explode(" ",$item['fin']);
    $listDate[$item['id_pc']] = $date[1];
}

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

renderView(
    'adminHome',
    [
        'pageTitle' => 'Administration',
        'errors' => $errors,
        'users' => $users,
        'listPC' => $listPC,
        'listDate' => $listDate
    ]
);
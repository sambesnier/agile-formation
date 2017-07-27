<?php
/**
 * Created by PhpStorm.
 * User: Samuel Besnier
 * Date: 25/07/2017
 * Time: 16:12
 */

$pdo = getPDO();

$errors = [];
$isSubmitted = filter_has_var(INPUT_POST, 'submit');
if ($isSubmitted) {
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = "";
    if ($_POST['password'] == $_POST['confirm']) {
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    } else {
        $errors[] = "Les mots de passe doivent correspondre";
    }
    $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
    $sexe = $_POST['sexe'];
    $numero = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);
    $voie = filter_input(INPUT_POST, 'voie', FILTER_SANITIZE_STRING);
    $ville = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_STRING);
    $codePostal = filter_input(INPUT_POST, 'codepostal', FILTER_SANITIZE_STRING);
    $pays = filter_input(INPUT_POST, 'pays', FILTER_SANITIZE_STRING);
    $newsletter = filter_has_var(INPUT_POST, 'newsletter');
    $captcha = $_POST['g-recaptcha-response'];

    if (empty($nom)) {
        $errors[] = "Vous devez saisir un nom";
    }
    if (empty($prenom)) {
        $errors[] = "Vous devez saisir un prénom";
    }
    if (empty($email)) {
        $errors[] = "Vous devez saisir un email";
    }
    if (empty($password)) {
        $errors[] = "Vous devez saisir un mot de passe";
    }
    if (empty($telephone)) {
        $errors[] = "Vous devez saisir un numéro de téléphone";
    }
    if (empty($sexe)) {
        $errors[] = "Vous devez sélectionner un sexe";
    }
    if (empty($numero)) {
        $errors[] = "Vous devez saisir un numéro de voie";
    }
    if (empty($voie)) {
        $errors[] = "Vous devez saisir un nom de voie";
    }
    if (empty($ville)) {
        $errors[] = "Vous devez saisir une ville";
    }
    if (empty($codePostal)) {
        $errors[] = "Vous devez saisir un code postal";
    }
    if (empty($pays)) {
        $errors[] = "Vous devez saisir un pays";
    }
    if (empty($captcha)) {
        $errors[] = "Vous devez valider le captcha";
    }

    // Vérification par google
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array('secret' => '6LctZyoUAAAAADrE8_XBHp9h0o5Vmb1cN6NflioS', 'response' => $captcha);

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */ }

    $rs = json_decode($result, true);

    if (!$rs['success']) {
        $errors[] = "Vous n'avez pas été validé par Google";
    }

    if (empty($errors)) {

        $pdo->beginTransaction();
        $sql = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, telephone, sexe, role, newsletter) VALUES (:nom, :prenom, :email, :password, :telephone, :sexe, :role, :newsletter)");
        $passcrypt = sha1($password);
        $role = "USER";
        $non = "N";
        $oui = "O";
        $sql->bindParam(':nom', $nom);
        $sql->bindParam(':prenom', $prenom);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':password', $passcrypt);
        $sql->bindParam(':telephone', $telephone);
        $sql->bindParam(':sexe', $sexe);
        $sql->bindParam(':role', $role);
        if ($newsletter) {
            $sql->bindParam(':newsletter', $non);
        } else {
            $sql->bindParam(':newsletter', $oui);
        }

        try {
            $sql->execute();
            $lastInsertId = $pdo->lastInsertId();
        } catch (PDOException $e) {
            $pdo->rollBack();
            $errors[] = "Erreur lors de l'enregistrement de l'utilisateur";
        }
        $sql = $pdo->prepare("INSERT INTO adresses (numero, voie, ville, cp, pays, id_user) VALUES (:numero, :voie, :ville, :cp, :pays, :id_user)");
        $sql->bindParam(':numero', $numero);
        $sql->bindParam(':voie', $voie);
        $sql->bindParam(':ville', $ville);
        $sql->bindParam(':cp', $codePostal);
        $sql->bindParam(':pays', $pays);
        $sql->bindParam(':id_user', $lastInsertId);
        try {
            $sql->execute();
            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            $errors[] = "Erreur lors de l'enregistrement de l'adresse";
        }
        $_SESSION['flash'] = ["success" => "Vous êtes maintenant inscrit"];
        header('Location: index.php?controller=accueil');
        exit();
    }
}


renderView(
    'inscription',
    [
        'pageTitle' => 'Inscription',
        'errors' => $errors
    ]
);
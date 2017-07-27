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
            $url = 'http://192.168.18.106/agile/web/index.php?controller=resetPassword&key='.$keyCrypted;

            sendMail($email, $url);
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

function sendMail($email, $url) {

    $message = <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Demystifying Email Design</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0; font-family: 'Century Gothic'">
 <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
 <tr>
  <td align="center" bgcolor="black" style="padding: 40px 0 30px 0;">
    <img src="http://192.168.18.106/agile/web/images/Image1.jpg" alt="Creating Email Magic" width="600" height="300" style="display: block;" />
  </td>
 </tr>
 <tr>
  <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
 <table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
   <td>
    <h1>Cyber-Agile</h1>
   </td>
  </tr>
  <tr>
   <td style="padding: 20px 0 30px 0;">
    Pour réinitialiser votre mot de passe, cliquez sur le lien suivant :<br><br> <a href="$url">Réinitialisation du mot de passe</a>
   </td>
  </tr>
 </table>
</td>
 </tr>
 <tr>
  <td align="center" bgcolor="black" style="padding: 10px 30px 10px 30px;">
   <a href="http://192.168.18.106/agile/web/" style="color: white;">www.cyber-agile.fr</a>
  </td>
 </tr>
</table>
</body>
</html>
EOD;

    $contact = 'contact@agile-mail.lan';
    $objet='Réinitialisation du mot de passe';
    $headers='From:'.$contact."\r\n".'To:'.$email."\r\n".'Subject:'.$objet."\r\n".'Content-type:text/html;charset=utf-8'."\r\n".'Sent:'.date('l, F d, Y H:i');
    if(mail($email,$objet,$message,$headers))
    {
        $_SESSION['flash'] = ['success' => 'Un lien pour réinitialiser votre mot de passe vous a été envoyé par mail'];
    }
    else {
        $_SESSION['flash'] = ['danger' => 'Un problème est survenu lors de l\'envoi du mail'];
    }
}
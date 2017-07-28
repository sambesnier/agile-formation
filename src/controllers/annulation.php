<?php
/**
 * Created by PhpStorm.
 * User: E4gleKnight
 * Date: 28/07/2017
 * Time: 14:07
 */

$email = filter_input(INPUT_GET,"email",FILTER_VALIDATE_EMAIL);

$comment = "votre réservation a été annulé";

sendMail($email,$comment);

header("Location: index.php?controller=adminHome");
exit();

function sendMail($email, $comment) {
    $objet='annulation de la réservation';
    $contact = 'contact@agile-mail.lan';
    $headers='From:'.$contact."\r\n".'To:'.$email."\r\n".'Subject:'.$objet."\r\n".'Content-type:text/html;charset=utf-8'."\r\n".'Sent:'.date('l, F d, Y H:i');
    if(mail($contact,$objet,$comment,$headers))
    {
        $_SESSION['flash'] = ["success" => "votre réservation a bien été annulé"];
    }
    else {
        $_SESSION['flash'] = ["danger" => "Erreur lors de l'envoi"];
    }
}
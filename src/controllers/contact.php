<?php

//Initialisation des erreurs
$errors=[];
//Récupération des données
$email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_STRING);
$nom = filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING);
$comment = filter_input(INPUT_POST,"message",FILTER_SANITIZE_STRING);
$isSubmitted = filter_has_var(INPUT_POST,"submit");
if ($isSubmitted){
    //Validation des données
    if (empty ($email)){
        $errors[]= "Vous devez saisir l'email";
    }
    if (empty($nom)){
        $errors[]="Vous devez saisir le nom";
    }
    if (empty($comment)){
        $errors[]="Vous devez saisir le message";
    }
    if (empty($errors)) {
        sendMail($email, $nom, $comment);
    }

}




renderView(
        'contact',
        [
            'errors' => $errors
        ]
);

function sendMail($email, $nom, $comment) {
    $objet='Contact '.$nom;
    $contact = 'contact@agile-mail.lan';
    $headers='From:'.$email."\r\n".'To:'.$contact."\r\n".'Subject:'.$objet."\r\n".'Content-type:text/plain;charset=utf-8'."\r\n".'Sent:'.date('l, F d, Y H:i');
    if(mail($contact,$objet,$comment,$headers))
    {
        $_SESSION['flash'] = ["success" => "Votre commentaire a bien été envoyé"];
    }
    else
        $_SESSION['flash'] = ["danger" => "Erreur lors de l'envoi"];
}
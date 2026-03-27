<?php
require_once 'config/session.php'; // UNIQUEMENT ICI
require ('actions/database.php');
if(isset($_GET['id']) AND !empty($_GET['id'])){
    $idOfTheMail = $_GET['id'];
    $informationOfTheMail = $bdd->prepare('SELECT * FROM mails WHERE id=?');
    $informationOfTheMail->execute([$idOfTheMail]);

    if($informationOfTheMail->rowCount() > 0){
        $mailInfos = $informationOfTheMail->fetch();
        $isUserTheAuthorOrTheReceiver = $_SESSION['id'] == $mailInfos['id_auteur'] || $_SESSION['id'] == $mailInfos['id_destinataire'];
        if($isUserTheAuthorOrTheReceiver){
            $mail_title = $mailInfos['titre'];
            $mail_content = $mailInfos['contenu'];
            $mail_author_firstname = $mailInfos['prenom_auteur'];
            $mail_author_lastname = $mailInfos['nom_auteur'];
            $mail_author_email = $mailInfos['email_auteur'];
            $mail_receiver_email = $mailInfos['email_destinataire'];

        }else{
            $errorMsg = "Ce mail ne vous appartient pas ou ne vous est pas destine ";
        }
    }else{
        $errorMsg = "Auncun mail trouve";
    }

}else{
    $errorMsg = "Auncun mail trouve";
}

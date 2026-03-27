<?php
require_once 'config/session.php'; // UNIQUEMENT ICI
require ('actions/database.php');
if(isset($_POST['validate'])){
    $verifIfAllInputsAreValid = !empty($_POST['object']) AND !empty($_POST['email_receiver']) AND !empty($_POST['content']);
    if($verifIfAllInputsAreValid){

        $email_receiver = htmlspecialchars($_POST['email_receiver']);
        $title_of_mail = htmlspecialchars($_POST['object']);
        $content_of_mail = nl2br(htmlspecialchars($_POST['content']));

        $checkIfReceiverExistsOnWebsite = $bdd->prepare('SELECT id, email FROM users WHERE email = ?');
        $checkIfReceiverExistsOnWebsite->execute([$email_receiver]);

        if($checkIfReceiverExistsOnWebsite->rowCount() > 0){
            $userInfos = $checkIfReceiverExistsOnWebsite->fetch();
         

            $insertMail = $bdd->prepare('INSERT INTO mails(titre, contenu, nom_auteur, prenom_auteur, email_auteur, id_auteur, id_destinataire, email_destinataire) VALUES (?,?,?,?,?,?,?,?)');
            $insertMail->execute(
                [
                    $title_of_mail,
                    $content_of_mail,
                    $_SESSION['nom'],
                    $_SESSION['prenom'],
                    $_SESSION['email'],
                    $_SESSION['id'],
                    $userInfos['id'],
                    $userInfos['email']
                ]
            );
            $succesMsg = "votre mail a ete envoye a l'adresse"." ".$email_receiver;
            

        }else{
            $errorMsg = "Le destinataire n'existe pas";
        }

    }else
        $errorMsg = "Veuillez completer tous les champs";
    
}

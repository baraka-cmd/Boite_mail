<?php
require_once 'config/session.php'; // UNIQUEMENT ICI
require ('actions/database.php');
if(isset($_POST['validate'])){
    if(!empty($_POST['object']) AND !empty($_POST['content'])){
        $mail_title = htmlspecialchars($_POST['object']);
        $mail_content = nl2br(htmlspecialchars($_POST['content']));
        $idOfTheMail = $_GET['id'];

        $updateInformationOftheMail = $bdd->prepare('UPDATE mails SET titre = ?, contenu = ? WHERE id = ?');
        $updateInformationOftheMail->execute(
            [
                $mail_title,
                $mail_content,
                $idOfTheMail
            ]
        );
        header('Location: my-mails.php');
    }
}

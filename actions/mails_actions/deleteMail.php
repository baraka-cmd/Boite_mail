<?php
require_once 'config/session.php'; // UNIQUEMENT ICI
require('../users_actions/authAction.php');
require('../database.php');
if(isset($_GET['id']) AND !empty($_GET['id'])){
    $idOfTheMail = $_GET['id'];
    $getAuthorIdTheMail = $bdd->prepare('SELECT id_auteur FROM mails WHERE id = ?');
    $getAuthorIdTheMail->execute([$idOfTheMail]);

    if($getAuthorIdTheMail->rowCount()> 0){
        $authorIdTheMail = $getAuthorIdTheMail->fetch();
        $authorIdTheMail = $authorIdTheMail['id_auteur'];

        if($_SESSION['id'] == $authorIdTheMail){
            $deleteThisMail = $bdd->prepare('DELETE FROM mails WHERE id = ?');
            $deleteThisMail->execute([$idOfTheMail]);
            header('Location: ../../my-mails.php');
        }else{
            echo "Vous n'avez pas le droit de supprimer ce mail";
        }
    }else{
        echo "Ce mail n'existe pas";
    }

}else{
    echo "Ce mail n'existe pas";
}

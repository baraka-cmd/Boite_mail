<?php
require_once 'config/session.php'; // UNIQUEMENT ICI
require ('actions/database.php');
if(isset($_POST['validate'])){
    if(!empty($_POST['content'])){
        $answer_content= nl2br(htmlspecialchars($_POST['content']));

        $insertMailsAnswers=$bdd->prepare('INSERT INTO answers(id_mail, email_auteur, nom_auteur, prenom_auteur, contenu) VALUES (?,?,?,?,?)');
        $insertMailsAnswers->execute(
            array(
                $_GET['id'],
                $_SESSION['email'],
                $_SESSION['nom'],
                $_SESSION['prenom'],
                $answer_content
            )  
        );
    }
}

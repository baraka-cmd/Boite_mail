<?php
require_once 'config/session.php'; // UNIQUEMENT ICI
require ('actions/database.php');
if(isset($_GET['id']) AND !empty($_GET['id'])){
    $getAllAnswersOfThisMail = $bdd->prepare('SELECT email_auteur, nom_auteur, prenom_auteur, contenu FROM answers WHERE id_mail = ? ORDER BY id DESC');
    $getAllAnswersOfThisMail->execute([$_GET['id']]);
}

<?php
require_once 'config/session.php'; // UNIQUEMENT ICI
    require ('actions/database.php');

    
$getReceivedMails = $bdd->prepare('SELECT id, titre, email_auteur, contenu FROM mails WHERE id_destinataire = ? ORDER BY id DESC');
$getReceivedMails->execute([$_SESSION['id']]);

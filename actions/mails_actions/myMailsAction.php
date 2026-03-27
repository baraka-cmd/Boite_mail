<?php
require_once 'config/session.php'; // UNIQUEMENT ICI
require ('actions/database.php');

$getAllSentMails = $bdd->prepare('SELECT id, titre, email_destinataire, contenu FROM mails WHERE id_auteur = ? ORDER BY id DESC');
$getAllSentMails->execute([$_SESSION['id']]);

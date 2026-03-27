<?php
$bdd = new PDO('mysql:host=localhost;dbname=boite-mail;charset=utf8;', 'root', '');
$insertUser = $bdd->prepare('INSERT INTO users(nom, prenom, email, mdp) VALUES (?,?,?,?)');
$insertUser->execute([
    'Claude',
    'Jean',
    'jeanclaude123@boitemail.com',
    password_hash('jeanclaude123', PASSWORD_DEFAULT)
]);
echo"Succes!";
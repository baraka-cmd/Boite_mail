<?php
// reset_password.php
$bdd = new PDO('mysql:host=localhost;dbname=boite-mail;charset=utf8;', 'root', '');

$email = "barakafelix006@gmail.com";
$nouveau_motdepasse = "Baraka006!!"; // Choisissez un nouveau

$hash = password_hash($nouveau_motdepasse, PASSWORD_DEFAULT);

$stmt = $bdd->prepare("UPDATE users SET mdp = ? WHERE email = ?");
$stmt->execute([$hash, $email]);

echo "✓ Mot de passe réinitialisé !<br>";
echo "Email: $email<br>";
echo "Nouveau mot de passe: $nouveau_motdepasse<br>";
echo "<a href='login.php'>Se connecter</a>";
?>
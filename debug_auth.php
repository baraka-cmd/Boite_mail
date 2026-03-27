<?php
// debug_auth.php
session_start();

echo "<h2>DEBUG Authentification</h2>";

// 1. Test session
echo "<h3>1. Session</h3>";
echo "Session ID: " . session_id() . "<br>";
echo "Session Status: " . session_status() . "<br>";
echo "_SESSION: <pre>";
print_r($_SESSION);
echo "</pre>";

// 2. Tester authAction
echo "<h3>2. Test authAction.php</h3>";
if (!isset($_SESSION['auth'])) {
    echo "✗ NON AUTHENTIFIÉ - Redirection vers login.php<br>";
    // Simuler la redirection
    echo "<script>setTimeout(() => window.location.href='login.php', 2000);</script>";
} else {
    echo "✓ AUTHENTIFIÉ<br>";
    echo "ID: " . ($_SESSION['id'] ?? 'N/A') . "<br>";
    echo "Email: " . ($_SESSION['email'] ?? 'N/A') . "<br>";
    echo "<a href='index.php'>Accéder à index.php</a><br>";
}

// 3. Tester la connexion manuelle
echo "<h3>3. Connexion manuelle</h3>";
echo "<form method='POST'>";
echo "Email: <input type='email' name='email' value='barakafelix006@gmail.com'><br>";
echo "Mot de passe: <input type='password' name='password'><br>";
echo "<input type='submit' name='login' value='Se connecter'>";
echo "</form>";

if (isset($_POST['login'])) {
    require 'actions/database.php';
    
    $stmt = $bdd->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    
    if ($user = $stmt->fetch()) {
        if (password_verify($_POST['password'], $user['mdp'])) {
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            
            echo "<div style='background:green;color:white;padding:10px;'>";
            echo "✓ CONNEXION RÉUSSIE !<br>";
            echo "Session mise à jour. <a href='index.php' style='color:white;'>Aller à index.php</a>";
            echo "</div>";
            
            // Redirection immédiate
            header("Refresh:2; url=index.php");
            
        } else {
            echo "<div style='background:red;color:white;padding:10px;'>";
            echo "✗ Mot de passe incorrect";
            echo "</div>";
        }
    } else {
        echo "✗ Utilisateur non trouvé";
    }
}
?>
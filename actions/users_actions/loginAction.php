<?php
require ('actions/database.php');

if(isset($_POST['validate'])){
    if(!empty($_POST['email']) AND !empty($_POST['password'])){
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $verifyIfUsersExixts = $bdd->prepare('SELECT * FROM users WHERE email = ?');
        $verifyIfUsersExixts->execute([$email]);

        if($verifyIfUsersExixts->rowCount() > 0){
            $userInfos = $verifyIfUsersExixts->fetch();
            if(password_verify($password, $userInfos['mdp'])){
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $userInfos['id'];
                $_SESSION['nom'] = $userInfos['nom'];
                $_SESSION['prenom'] = $userInfos['prenom'];
                $_SESSION['email'] = $userInfos['email'];

                header('Location: index.php');
            }else{
                $errorMsg = "Votre mot de passe est incorrect";
            }
        }else{
            $errorMsg = "Aucun utilisateur trouve";
        }
    }else{
        $errorMsg = "Veuillez completer tous les champs";
    }
}
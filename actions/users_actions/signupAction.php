<?php
require ('actions/database.php');

function endsWith($string, $endString){
    $len = strlen($endString);
    if($len == 0){
        return true;
    }
    return (substr($string, -$len) === $endString);
}


if(isset($_POST['validate'])){

    $verifIfAllInputsAreValid = !empty($_POST['email']) AND !empty($_POST['lastname']) AND !empty($_POST['firstname']) AND !empty($_POST['password']);
    if($verifIfAllInputsAreValid){
        $email = htmlspecialchars($_POST['email']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $verifIfUseExists = $bdd->prepare('SELECT email FROM users WHERE email = ?');
        $verifIfUseExists->execute([$email]);

        if($verifIfUseExists->rowCount() == 0){
            
                $insertUserExists = $bdd->prepare('INSERT INTO users(nom, prenom, email, mdp) VALUES (?,?,?,?)');
                $insertUserExists->execute([$lastname, $firstname, $email, $password]);

                $getAllUsersInfosReq = $bdd->prepare('SELECT id, nom, prenom, email FROM users WHERE email = ?');
                $getAllUsersInfosReq->execute([$email]);

                if($getAllUsersInfosReq->rowCount() > 0){
                    $userInfos = $getAllUsersInfosReq->fetch();
                    $_SESSION['auth'] = true;
                    $_SESSION['id'] = $userInfos['id'];
                    $_SESSION['nom'] = $userInfos['nom'];
                    $_SESSION['prenom'] = $userInfos['prenom'];
                    $_SESSION['email'] = $userInfos['email'];

                    header('Location: login.php');
                    exit();
                }
           
        }else{
            $errorMsg = "Un utilisateur possede deja cette adresse mail";
        }

    }else{
        $errorMsg = "Veuillez completer tous les champs";
    }
}
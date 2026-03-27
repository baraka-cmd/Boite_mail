<?php require ('actions/users_actions/loginAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Boîte Mail</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-wrapper">
            
            <!-- Header -->
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-envelope"></i>
                    <h1>Boîte Mail</h1>
                </div>
                <p class="tagline">Connectez-vous pour accéder à votre messagerie</p>
            </div>

            <!-- Main Content -->
            <div class="login-content">
                <div class="login-card">
                    <div class="card-header">
                        <h2><i class="fas fa-sign-in-alt"></i> Connexion</h2>
                        <p>Accédez à votre compte</p>
                    </div>

                    <!-- Error Message -->
                    <?php if(isset($errorMsg)): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo $errorMsg; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form class="login-form" method="POST">
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Adresse email
                            </label>
                            <div class="input-with-icon">
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    placeholder="Entrer votre adresse mail" 
                                    required
                                    autocomplete="off"
                                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                >
                                <i class="fas fa-user-circle input-icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i> Mot de passe
                            </label>
                            <div class="input-with-icon">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Entrer votre mot de passe" 
                                    required
                                    autocomplete="off"
                                >
                                <i class="fas fa-key input-icon"></i>
                                <button type="button" class="toggle-password" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn-login" name="validate">
                            <i class="fas fa-sign-in-alt"></i> Se connecter
                        </button>

                        <div class="signup-link">
                            <p>Pas encore de compte ?</p>
                            <a href="signup.php" class="btn-signup">
                                <i class="fas fa-user-plus"></i> Je m'inscris
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Auto-hide error message after 5 seconds
        setTimeout(() => {
            const errorAlert = document.querySelector('.alert-error');
            if (errorAlert) {
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.style.display = 'none', 300);
            }
        }, 5000);
        
        // Validation côté client améliorée
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('.login-form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    let isValid = true;
                    let errorMessages = [];
                    
                    // Validation email
                    const email = emailInput.value.trim();
                    if (!email) {
                        errorMessages.push('L\'adresse email est requise');
                        isValid = false;
                    } else if (!validateEmail(email)) {
                        errorMessages.push('Adresse email invalide');
                        isValid = false;
                    }
                    
                    // Validation mot de passe
                    const password = passwordInput.value;
                    if (!password) {
                        errorMessages.push('Le mot de passe est requis');
                        isValid = false;
                    } else if (password.length < 8) {
                        errorMessages.push('Le mot de passe doit contenir au moins 8 caractères');
                        isValid = false;
                    }
                    
                    if (!isValid) {
                        e.preventDefault();
                        showErrorMessages(errorMessages);
                    }
                });
                
                // Fonction de validation email
                function validateEmail(email) {
                    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return re.test(email);
                }
                
                // Afficher les erreurs
                function showErrorMessages(messages) {
                    // Créer ou mettre à jour le conteneur d'erreur
                    let errorContainer = document.querySelector('.client-error-container');
                    if (!errorContainer) {
                        errorContainer = document.createElement('div');
                        errorContainer.className = 'alert alert-error client-error-container';
                        loginForm.insertBefore(errorContainer, loginForm.firstChild);
                    }
                    
                    // Afficher les messages
                    errorContainer.innerHTML = `
                        <i class="fas fa-exclamation-circle"></i>
                        <div class="error-list">
                            ${messages.map(msg => `<div>${msg}</div>`).join('')}
                        </div>
                    `;
                    
                    // Auto-hide après 10 secondes
                    setTimeout(() => {
                        errorContainer.style.opacity = '0';
                        setTimeout(() => errorContainer.remove(), 300);
                    }, 10000);
                }
            }
            
            // Protection contre les formulaires automatiques
            let lastSubmitTime = 0;
            const submitButton = document.querySelector('.btn-login');
            if (submitButton) {
                submitButton.addEventListener('click', function() {
                    const now = Date.now();
                    if (now - lastSubmitTime < 2000) { // 2 secondes minimum entre les soumissions
                        event.preventDefault();
                        alert('Veuillez patienter avant de réessayer.');
                        return false;
                    }
                    lastSubmitTime = now;
                });
            }
        });
    </script>
</body>
</html>
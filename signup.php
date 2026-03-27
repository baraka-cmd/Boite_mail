<?php require ('actions/users_actions/signupAction.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Boîte Mail</title>
    <link rel="stylesheet" href="style/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="signup-box">
            <!-- Header -->
            <div class="header">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h1 class="logo-text">Boîte Mail</h1>
                </div>
                <p class="subtitle">Créez votre compte pour commencer à utiliser la messagerie</p>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="form-section">
                    <h2 class="form-title">
                        <i class="fas fa-user-plus"></i> Créer un compte
                    </h2>
                    <p class="form-subtitle">Remplissez les informations ci-dessous</p>

                    <!-- Error Message -->
                    <?php if(isset($errorMsg)): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo htmlspecialchars($errorMsg); ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- Success Message (optional) -->
                    <?php if(isset($successMsg)): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo htmlspecialchars($successMsg); ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- Signup Form -->
                    <form class="signup-form" method="POST">
                        <!-- Name Fields -->
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Nom
                                </label>
                                <input 
                                    type="text" 
                                    name="lastname" 
                                    class="form-input"
                                    placeholder="Entrer votre nom"
                                    value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Prénom
                                </label>
                                <input 
                                    type="text" 
                                    name="firstname" 
                                    class="form-input"
                                    placeholder="Entrer votre prénom"
                                    value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope"></i> Adresse email
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-input"
                                placeholder="Entrer votre email"
                                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                required
                            >
                            <small class="form-hint">
                                <i class="fas fa-info-circle"></i> Vous utiliserez cette adresse pour vous connecter
                            </small>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock"></i> Mot de passe
                            </label>
                            <div class="password-wrapper">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password"
                                    class="form-input password-input"
                                    placeholder="Entrer votre mot de passe"
                                    required
                                >
                                <button type="button" class="toggle-password" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <!-- Password Strength -->
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="passwordStrength"></div>
                                </div>
                                <small class="form-hint">
                                    <i class="fas fa-shield-alt"></i> Utilisez au moins 8 caractères avec majuscules, minuscules et chiffres
                                </small>
                            </div>
                        </div>

                        <!-- Checkboxes -->
                        <div class="checkbox-section">
                            <label class="checkbox-item">
                                <input type="checkbox" name="terms" id="terms" required>
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">
                                    J'accepte les <a href="#" class="text-link">conditions d'utilisation</a> et la 
                                    <a href="#" class="text-link">politique de confidentialité</a>
                                </span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="newsletter" id="newsletter">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">
                                    Je souhaite recevoir les actualités et offres spéciales
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" name="validate" class="submit-btn">
                            <i class="fas fa-user-plus"></i> Créer mon compte
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span class="divider-text">ou</span>
                        </div>

                        <!-- Google Signup -->
                        <button type="button" class="google-btn">
                            <i class="fab fa-google"></i> S'inscrire avec Google
                        </button>

                        <!-- Login Link -->
                        <div class="login-redirect">
                            <p class="login-text">Déjà un compte ?</p>
                            <a href="login.php" class="login-link">
                                <i class="fas fa-sign-in-alt"></i> Se connecter
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Features Section -->
                <div class="features-section">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Sécurisé</h3>
                        <p class="feature-desc">Vos données sont protégées</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3 class="feature-title">Rapide</h3>
                        <p class="feature-desc">Interface optimisée</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">Support</h3>
                        <p class="feature-desc">Aide disponible 24/7</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="footer-links">
                    <a href="#" class="footer-link">Confidentialité</a>
                    <a href="#" class="footer-link">Conditions</a>
                    <a href="#" class="footer-link">Aide</a>
                    <a href="#" class="footer-link">Contact</a>
                </div>
                
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
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
        }

        // Password strength indicator
        const passwordField = document.getElementById('password');
        const strengthBar = document.getElementById('passwordStrength');
        
        if (passwordField && strengthBar) {
            passwordField.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Length check
                if (password.length >= 8) strength += 20;
                if (password.length >= 12) strength += 10;
                
                // Character variety checks
                if (/[A-Z]/.test(password)) strength += 20;
                if (/[a-z]/.test(password)) strength += 20;
                if (/[0-9]/.test(password)) strength += 20;
                if (/[^A-Za-z0-9]/.test(password)) strength += 10;
                
                // Cap at 100
                strength = Math.min(strength, 100);
                
                // Update bar
                strengthBar.style.width = strength + '%';
                
                // Update color
                if (strength < 40) {
                    strengthBar.style.backgroundColor = '#ea4335';
                } else if (strength < 70) {
                    strengthBar.style.backgroundColor = '#fbbc05';
                } else {
                    strengthBar.style.backgroundColor = '#34a853';
                }
            });
        }

        // Form validation
        const signupForm = document.querySelector('.signup-form');
        const termsCheckbox = document.getElementById('terms');
        
        if (signupForm && termsCheckbox) {
            signupForm.addEventListener('submit', function(e) {
                if (!termsCheckbox.checked) {
                    e.preventDefault();
                    alert('Veuillez accepter les conditions d\'utilisation pour continuer.');
                    termsCheckbox.focus();
                    return false;
                }
                return true;
            });
        }

        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.error-message, .success-message');
            messages.forEach(function(message) {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-10px)';
                setTimeout(function() {
                    message.style.display = 'none';
                }, 300);
            });
        }, 5000);
    </script>
</body>
</html>
<?php
require('actions/users_actions/authAction.php');
require('actions/mails_actions/showMailContent.php');
require('actions/mails_actions/editMailAction.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le mail - Boîte Mail</title>
    <link rel="stylesheet" href="style/edit-mail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
</head>
<body>
    <div class="edit-mail-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-envelope"></i>
                    <h1>Boîte Mail</h1>
                </div>
                <button class="compose-btn" onclick="window.location.href='send-mail.php'">
                    <i class="fas fa-pen"></i> Rédiger
                </button>
            </div>

            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item">
                    <i class="fas fa-inbox"></i>
                    <span>Boîte de réception</span>
                </a>
                <a href="send-mail.php" class="nav-item">
                    <i class="fas fa-paper-plane"></i>
                    <span>Envoyer un mail</span>
                </a>
                <a href="my-mails.php" class="nav-item">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Mails envoyés</span>
                </a>
                <a href="#" class="nav-item active">
                    <i class="fas fa-edit"></i>
                    <span>Modifier</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($_SESSION['prenom'], 0, 1) . substr($_SESSION['nom'], 0, 1)); ?>
                    </div>
                    <div class="user-details">
                        <strong><?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?></strong>
                        <small><?php echo htmlspecialchars($_SESSION['email']); ?></small>
                    </div>
                </div>
                <a href="actions/users_actions/logoutAction.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="edit-header">
                <div class="header-left">
                    <a href="my-mails.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <h1 class="page-title">
                        <i class="fas fa-edit"></i> Modifier le mail
                    </h1>
                </div>
                <div class="header-right">
                    <button class="preview-btn" onclick="previewMail()">
                        <i class="fas fa-eye"></i> Aperçu
                    </button>
                </div>
            </header>

            <!-- Error Message -->
            <?php if(isset($errorMsg)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($errorMsg); ?></span>
            </div>
            <?php endif; ?>

            <!-- Success Message (optional) -->
            <?php if(isset($successMsg)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span><?php echo htmlspecialchars($successMsg); ?></span>
            </div>
            <?php endif; ?>

            <!-- Edit Form -->
            <?php if(isset($mail_receiver_email)): ?>
            <div class="edit-form-container">
                <form class="edit-form" method="POST">
                    <!-- Mail Info -->
                    <div class="mail-info-card">
                        <div class="info-item">
                            <span class="info-label">De :</span>
                            <span class="info-value"><?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?> (<?php echo htmlspecialchars($_SESSION['email']); ?>)</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">À :</span>
                            <span class="info-value"><?php echo htmlspecialchars($mail_receiver_email); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Original de :</span>
                            <span class="info-value"><?php echo htmlspecialchars($mail_author_lastname . ' ' . $mail_author_firstname); ?> (<?php echo htmlspecialchars($mail_author_email); ?>)</span>
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tag"></i> Objet du mail
                        </label>
                        <input 
                            type="text" 
                            name="object" 
                            class="form-input"
                            value="<?php echo htmlspecialchars($mail_title); ?>"
                            placeholder="Objet du mail"
                            required
                        >
                    </div>

                    <!-- Content Editor -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file-alt"></i> Contenu du mail
                        </label>
                        <div class="editor-toolbar" id="toolbar">
                            <div class="toolbar-group">
                                <button type="button" class="toolbar-btn" data-command="bold" title="Gras">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" class="toolbar-btn" data-command="italic" title="Italique">
                                    <i class="fas fa-italic"></i>
                                </button>
                                <button type="button" class="toolbar-btn" data-command="underline" title="Souligner">
                                    <i class="fas fa-underline"></i>
                                </button>
                            </div>
                            <div class="toolbar-group">
                                <button type="button" class="toolbar-btn" data-command="insertUnorderedList" title="Liste à puces">
                                    <i class="fas fa-list-ul"></i>
                                </button>
                                <button type="button" class="toolbar-btn" data-command="insertOrderedList" title="Liste numérotée">
                                    <i class="fas fa-list-ol"></i>
                                </button>
                            </div>
                            <div class="toolbar-group">
                                <button type="button" class="toolbar-btn" data-command="justifyLeft" title="Aligner à gauche">
                                    <i class="fas fa-align-left"></i>
                                </button>
                                <button type="button" class="toolbar-btn" data-command="justifyCenter" title="Centrer">
                                    <i class="fas fa-align-center"></i>
                                </button>
                                <button type="button" class="toolbar-btn" data-command="justifyRight" title="Aligner à droite">
                                    <i class="fas fa-align-right"></i>
                                </button>
                            </div>
                            <div class="toolbar-group">
                                <button type="button" class="toolbar-btn" id="insertLink" title="Insérer un lien">
                                    <i class="fas fa-link"></i>
                                </button>
                                <button type="button" class="toolbar-btn" id="insertImage" title="Insérer une image">
                                    <i class="fas fa-image"></i>
                                </button>
                            </div>
                        </div>
                        <textarea 
                            name="content" 
                            id="mailContent" 
                            class="editor-textarea"
                            placeholder="Écrivez votre contenu ici..."
                            required
                        ><?php echo htmlspecialchars($mail_content); ?></textarea>
                        <div class="editor-footer">
                            <span class="char-count" id="charCount">0 caractères</span>
                            <div class="editor-options">
                                <label class="option-checkbox">
                                    <input type="checkbox" id="autoSave">
                                    <span class="checkmark"></span>
                                    Sauvegarde automatique
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        <div class="action-buttons">
                            <button type="button" class="btn-cancel" onclick="window.location.href='my-mails.php'">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                            <button type="button" class="btn-save-draft" onclick="saveAsDraft()">
                                <i class="fas fa-save"></i> Enregistrer comme brouillon
                            </button>
                            <button type="submit" name="validate" class="btn-submit">
                                <i class="fas fa-check"></i> Enregistrer les modifications
                            </button>
                        </div>
                        <div class="action-options">
                            <div class="option-group">
                                <label class="option-label">
                                    <i class="fas fa-paperclip"></i> Ajouter une pièce jointe
                                </label>
                                <input type="file" id="attachment" class="file-input" multiple>
                            </div>
                            <div class="option-group">
                                <label class="option-label">
                                    <i class="fas fa-bell"></i> Options de notification
                                </label>
                                <select class="notification-select">
                                    <option value="">Notification normale</option>
                                    <option value="urgent">Marquer comme urgent</option>
                                    <option value="confirmation">Demander un accusé de réception</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Preview Panel (Hidden by default) -->
                <div class="preview-panel" id="previewPanel">
                    <div class="preview-header">
                        <h3><i class="fas fa-eye"></i> Aperçu du mail</h3>
                        <button class="close-preview" onclick="closePreview()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="preview-content">
                        <div class="preview-subject">
                            <strong>Objet :</strong> <span id="previewSubject"><?php echo htmlspecialchars($mail_title); ?></span>
                        </div>
                        <div class="preview-body">
                            <strong>Contenu :</strong>
                            <div id="previewBody" class="preview-text"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <!-- No Mail Found -->
                <div class="no-mail">
                    <div class="no-mail-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h2>Mail non trouvé</h2>
                    <p>Le mail que vous essayez de modifier n'existe pas ou vous n'y avez pas accès.</p>
                    <a href="my-mails.php" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Retour aux mails envoyés
                    </a>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

    <!-- JavaScript -->
    <script>
        // Initialize editor
        $(document).ready(function() {
            $('#mailContent').summernote({
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                placeholder: 'Écrivez votre contenu ici...',
                callbacks: {
                    onChange: function(contents) {
                        updateCharCount();
                        autoSave();
                    },
                    onPaste: function(e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    }
                }
            });

            // Set initial content
            $('#mailContent').summernote('code', `<?php echo addslashes($mail_content); ?>`);
        });

        // Character count
        function updateCharCount() {
            const content = $('#mailContent').summernote('code');
            const charCount = content.replace(/<[^>]*>/g, '').length;
            $('#charCount').text(charCount + ' caractères');
        }

        // Update char count on load
        setTimeout(updateCharCount, 100);

        // Auto-save functionality
        let autoSaveTimer;
        function autoSave() {
            if (document.getElementById('autoSave').checked) {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(saveDraft, 2000);
            }
        }

        function saveDraft() {
            const subject = document.querySelector('[name="object"]').value;
            const content = $('#mailContent').summernote('code');
            
            // Save to localStorage for demo
            localStorage.setItem('mailDraft', JSON.stringify({
                subject: subject,
                content: content,
                timestamp: new Date().toISOString()
            }));
            
            showToast('Brouillon sauvegardé', 'success');
        }

        function saveAsDraft() {
            saveDraft();
            showToast('Mail enregistré comme brouillon', 'success');
        }

        // Preview functionality
        function previewMail() {
            const subject = document.querySelector('[name="object"]').value;
            const content = $('#mailContent').summernote('code');
            
            document.getElementById('previewSubject').textContent = subject || '(Sans objet)';
            document.getElementById('previewBody').innerHTML = content || '<em>Aucun contenu</em>';
            
            document.getElementById('previewPanel').classList.add('show');
        }

        function closePreview() {
            document.getElementById('previewPanel').classList.remove('show');
        }

        // Toast notifications
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Custom toolbar buttons
        document.querySelectorAll('.toolbar-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const command = this.getAttribute('data-command');
                document.execCommand(command, false, null);
                $('#mailContent').summernote('focus');
            });
        });

        document.getElementById('insertLink').addEventListener('click', function() {
            const url = prompt('Entrez l\'URL:', 'https://');
            if (url) {
                document.execCommand('createLink', false, url);
            }
        });

        document.getElementById('insertImage').addEventListener('click', function() {
            const url = prompt('Entrez l\'URL de l\'image:', 'https://');
            if (url) {
                document.execCommand('insertImage', false, url);
            }
        });

        // Auto-hide messages
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.style.display = 'none', 300);
            });
        }, 5000);

        // Load draft if exists
        const savedDraft = localStorage.getItem('mailDraft');
        if (savedDraft) {
            try {
                const draft = JSON.parse(savedDraft);
                const hoursAgo = (new Date() - new Date(draft.timestamp)) / (1000 * 60 * 60);
                
                if (hoursAgo < 24) { // Only load drafts from last 24 hours
                    if (confirm('Un brouillon non sauvegardé a été trouvé. Voulez-vous le charger ?')) {
                        document.querySelector('[name="object"]').value = draft.subject || '';
                        $('#mailContent').summernote('code', draft.content || '');
                        updateCharCount();
                    }
                }
            } catch (e) {
                console.error('Error loading draft:', e);
            }
        }

        // Form validation
        document.querySelector('.edit-form').addEventListener('submit', function(e) {
            const subject = document.querySelector('[name="object"]').value.trim();
            const content = $('#mailContent').summernote('code').trim();
            
            if (!subject) {
                e.preventDefault();
                showToast('Veuillez saisir un objet pour le mail', 'error');
                document.querySelector('[name="object"]').focus();
                return false;
            }
            
            if (!content || content === '<p><br></p>') {
                e.preventDefault();
                showToast('Le contenu du mail ne peut pas être vide', 'error');
                $('#mailContent').summernote('focus');
                return false;
            }
            
            // Clear draft on successful submit
            localStorage.removeItem('mailDraft');
            return true;
        });

        // Warn before leaving if unsaved changes
        let hasUnsavedChanges = false;
        
        document.querySelector('[name="object"]').addEventListener('input', () => hasUnsavedChanges = true);
        $('#mailContent').on('summernote.change', () => hasUnsavedChanges = true);
        
        window.addEventListener('beforeunload', function(e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
</body>
</html>
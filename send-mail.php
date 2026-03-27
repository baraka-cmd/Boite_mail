<?php 
require('actions/users_actions/authAction.php');
require('actions/mails_actions/sendMailAction.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message - Boîte Mail</title>
    <link rel="stylesheet" href="style/compose.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
    <div class="compose-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="index.php" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-envelope"></i>
                        <h1>Boîte Mail</h1>
                    </a>
                </div>
                <button class="compose-btn active">
                    <i class="fas fa-pen"></i> Rédiger
                </button>
            </div>

            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item">
                    <i class="fas fa-inbox"></i>
                    <span>Boîte de réception</span>
                </a>
                <a href="my-mails.php" class="nav-item">
                    <i class="fas fa-paper-plane"></i>
                    <span>Envoyés</span>
                </a>
                <a href="send-mail.php" class="nav-item active">
                    <i class="fas fa-edit"></i>
                    <span>Nouveau message</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-star"></i>
                    <span>Importants</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-clock"></i>
                    <span>Brouillons</span>
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
            <!-- Compose Header -->
            <header class="compose-header">
                <div class="header-left">
                    <a href="index.php" class="back-btn" id="cancelCompose">
                        <i class="fas fa-times"></i>
                    </a>
                    <h2><i class="fas fa-pen"></i> Nouveau message</h2>
                </div>
                <div class="header-right">
                    <button type="button" class="header-btn" id="saveDraft">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <button type="button" class="header-btn" id="discardDraft">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </div>
            </header>

            <!-- Compose Form -->
            <div class="compose-form-wrapper">
                <?php if(isset($errorMsg) || isset($succesMsg)): ?>
                <div class="messages-container">
                    <?php if(isset($errorMsg)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo htmlspecialchars($errorMsg); ?></span>
                        <button class="close-alert">&times;</button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($succesMsg)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo htmlspecialchars($succesMsg); ?></span>
                        <button class="close-alert">&times;</button>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <form class="compose-form" method="POST" id="composeForm">
                    <!-- Recipient -->
                    <div class="form-row">
                        <label class="form-label">
                            <i class="fas fa-user"></i> À
                        </label>
                        <div class="recipient-field">
                            <input 
                                type="email" 
                                name="email_receiver" 
                                class="form-input recipient-input"
                                placeholder="Entrez l'adresse email du destinataire"
                                value="<?php echo isset($_POST['email_receiver']) ? htmlspecialchars($_POST['email_receiver']) : ''; ?>"
                                required
                            >
                            <button type="button" class="add-recipient-btn" title="Ajouter Cc/Cci">
                                Cc/Cci
                            </button>
                        </div>
                    </div>

                    <!-- CC/BCC Fields (Hidden by default) -->
                    <div class="additional-recipients" id="additionalRecipients">
                        <div class="form-row">
                            <label class="form-label">
                                <i class="fas fa-user-friends"></i> Cc
                            </label>
                            <input 
                                type="email" 
                                name="email_cc" 
                                class="form-input"
                                placeholder="Copie carbone"
                            >
                        </div>
                        <div class="form-row">
                            <label class="form-label">
                                <i class="fas fa-user-secret"></i> Cci
                            </label>
                            <input 
                                type="email" 
                                name="email_bcc" 
                                class="form-input"
                                placeholder="Copie carbone invisible"
                            >
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="form-row">
                        <label class="form-label">
                            <i class="fas fa-tag"></i> Objet
                        </label>
                        <input 
                            type="text" 
                            name="object" 
                            class="form-input"
                            placeholder="Entrez l'objet du message"
                            value="<?php echo isset($_POST['object']) ? htmlspecialchars($_POST['object']) : ''; ?>"
                            required
                        >
                    </div>

                    <!-- Editor Toolbar -->
                    <div class="editor-toolbar" id="editorToolbar">
                        <div class="toolbar-group">
                            <button type="button" class="toolbar-btn" data-command="bold" title="Gras (Ctrl+B)">
                                <i class="fas fa-bold"></i>
                            </button>
                            <button type="button" class="toolbar-btn" data-command="italic" title="Italique (Ctrl+I)">
                                <i class="fas fa-italic"></i>
                            </button>
                            <button type="button" class="toolbar-btn" data-command="underline" title="Souligné (Ctrl+U)">
                                <i class="fas fa-underline"></i>
                            </button>
                            <div class="separator"></div>
                            <button type="button" class="toolbar-btn" data-command="insertUnorderedList" title="Liste à puces">
                                <i class="fas fa-list-ul"></i>
                            </button>
                            <button type="button" class="toolbar-btn" data-command="insertOrderedList" title="Liste numérotée">
                                <i class="fas fa-list-ol"></i>
                            </button>
                            <div class="separator"></div>
                            <button type="button" class="toolbar-btn" data-command="createLink" title="Insérer un lien">
                                <i class="fas fa-link"></i>
                            </button>
                            <button type="button" class="toolbar-btn" data-command="formatBlock" data-value="blockquote" title="Citation">
                                <i class="fas fa-quote-right"></i>
                            </button>
                            <button type="button" class="toolbar-btn" data-command="formatBlock" data-value="pre" title="Code">
                                <i class="fas fa-code"></i>
                            </button>
                        </div>
                        <div class="toolbar-group">
                            <select class="font-select" id="fontSelect">
                                <option value="">Police</option>
                                <option value="Arial">Arial</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Verdana">Verdana</option>
                                <option value="Courier New">Courier New</option>
                            </select>
                            <select class="size-select" id="sizeSelect">
                                <option value="">Taille</option>
                                <option value="1">Petit</option>
                                <option value="3">Normal</option>
                                <option value="5">Grand</option>
                                <option value="7">Très grand</option>
                            </select>
                            <div class="separator"></div>
                            <button type="button" class="toolbar-btn" id="textColor" title="Couleur du texte">
                                <i class="fas fa-font"></i>
                            </button>
                            <button type="button" class="toolbar-btn" id="bgColor" title="Couleur de fond">
                                <i class="fas fa-highlighter"></i>
                            </button>
                            <div class="separator"></div>
                            <button type="button" class="toolbar-btn" id="insertImage" title="Insérer une image">
                                <i class="fas fa-image"></i>
                            </button>
                            <button type="button" class="toolbar-btn" id="attachFile" title="Joindre un fichier">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <button type="button" class="toolbar-btn" id="insertEmoji" title="Insérer un émoji">
                                <i class="fas fa-smile"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Editor -->
                    <div class="editor-container">
                        <div id="editor" class="editor-content" contenteditable="true" data-placeholder="Écrivez votre message ici...">
                            <?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?>
                        </div>
                        <textarea name="content" id="hiddenContent" style="display: none;"></textarea>
                    </div>

                    <!-- Attachments -->
                    <div class="attachments-container" id="attachmentsContainer">
                        <div class="attachments-header">
                            <i class="fas fa-paperclip"></i>
                            <span>Pièces jointes</span>
                            <button type="button" class="add-attachment-btn" id="addAttachment">
                                <i class="fas fa-plus"></i> Ajouter
                            </button>
                        </div>
                        <div class="attachments-list" id="attachmentsList">
                            <!-- Attachments will be added here -->
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <div class="actions-left">
                            <button type="submit" name="validate" class="send-btn">
                                <i class="fas fa-paper-plane"></i> Envoyer
                            </button>
                            <button type="button" class="more-options-btn" id="moreOptions">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="more-options" id="moreOptionsMenu">
                                <div class="option-item">
                                    <input type="checkbox" id="urgent" name="urgent">
                                    <label for="urgent">
                                        <i class="fas fa-exclamation-circle"></i> Urgent
                                    </label>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" id="confirmation" name="confirmation">
                                    <label for="confirmation">
                                        <i class="fas fa-check-circle"></i> Demander un accusé de réception
                                    </label>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" id="encryption" name="encryption">
                                    <label for="encryption">
                                        <i class="fas fa-lock"></i> Chiffrer le message
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="actions-right">
                            <button type="button" class="action-btn" title="Vérifier l'orthographe">
                                <i class="fas fa-spell-check"></i>
                            </button>
                            <button type="button" class="action-btn" title="Aperçu">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="action-btn" title="Plus d'options">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Recipient Suggestions -->
            <div class="suggestions-container" id="suggestionsContainer">
                <div class="suggestions-header">
                    <i class="fas fa-users"></i>
                    <span>Suggestions de contacts</span>
                </div>
                <div class="suggestions-list">
                    <!-- Suggestions will be populated by JavaScript -->
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        // Initialize editor
        const editor = document.getElementById('editor');
        const hiddenContent = document.getElementById('hiddenContent');
        
        // Save content to hidden textarea before form submission
        document.getElementById('composeForm').addEventListener('submit', function(e) {
            hiddenContent.value = editor.innerHTML;
            
            // Basic validation
            const recipient = document.querySelector('[name="email_receiver"]').value;
            const subject = document.querySelector('[name="object"]').value;
            const content = editor.innerHTML.trim();
            
            if (!recipient || !subject || !content) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires.');
                return false;
            }
            
            return true;
        });

        // Editor toolbar functionality
        document.querySelectorAll('.toolbar-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const command = this.getAttribute('data-command');
                const value = this.getAttribute('data-value');
                
                if (command === 'createLink') {
                    const url = prompt('Entrez l\'URL:', 'https://');
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                } else if (value) {
                    document.execCommand(command, false, value);
                } else {
                    document.execCommand(command, false, null);
                }
                
                editor.focus();
            });
        });

        // Font and size select
        document.getElementById('fontSelect').addEventListener('change', function() {
            const font = this.value;
            if (font) {
                document.execCommand('fontName', false, font);
            }
            editor.focus();
        });

        document.getElementById('sizeSelect').addEventListener('change', function() {
            const size = this.value;
            if (size) {
                document.execCommand('fontSize', false, size);
            }
            editor.focus();
        });

        // Color pickers
        document.getElementById('textColor').addEventListener('click', function() {
            const color = prompt('Entrez une couleur (nom ou hexadécimal):', '#000000');
            if (color) {
                document.execCommand('foreColor', false, color);
            }
            editor.focus();
        });

        document.getElementById('bgColor').addEventListener('click', function() {
            const color = prompt('Entrez une couleur de fond:', '#ffff00');
            if (color) {
                document.execCommand('backColor', false, color);
            }
            editor.focus();
        });

        // Image insertion
        document.getElementById('insertImage').addEventListener('click', function() {
            const url = prompt('Entrez l\'URL de l\'image:', 'https://');
            if (url) {
                document.execCommand('insertImage', false, url);
            }
            editor.focus();
        });

        // Emoji insertion
        document.getElementById('insertEmoji').addEventListener('click', function() {
            const emoji = prompt('Entrez un émoji ou choisissez: 😀 😂 😍 😎 👍', '😀');
            if (emoji) {
                document.execCommand('insertText', false, emoji);
            }
            editor.focus();
        });

        // File attachment
        document.getElementById('attachFile').addEventListener('click', function() {
            const input = document.createElement('input');
            input.type = 'file';
            input.multiple = true;
            input.accept = '*/*';
            
            input.addEventListener('change', function(e) {
                const files = e.target.files;
                for (let file of files) {
                    addAttachment(file);
                }
            });
            
            input.click();
        });

        function addAttachment(file) {
            const attachmentsList = document.getElementById('attachmentsList');
            const attachmentItem = document.createElement('div');
            attachmentItem.className = 'attachment-item';
            
            const fileIcon = getFileIcon(file.type);
            
            attachmentItem.innerHTML = `
                <div class="attachment-icon">
                    <i class="${fileIcon}"></i>
                </div>
                <div class="attachment-info">
                    <div class="attachment-name">${file.name}</div>
                    <div class="attachment-size">${formatFileSize(file.size)}</div>
                </div>
                <button type="button" class="remove-attachment" title="Supprimer">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            attachmentsList.appendChild(attachmentItem);
            document.getElementById('attachmentsContainer').style.display = 'block';
            
            // Remove attachment
            attachmentItem.querySelector('.remove-attachment').addEventListener('click', function() {
                attachmentItem.remove();
                if (attachmentsList.children.length === 0) {
                    document.getElementById('attachmentsContainer').style.display = 'none';
                }
            });
        }

        function getFileIcon(mimeType) {
            if (mimeType.includes('image/')) return 'fas fa-file-image';
            if (mimeType.includes('pdf')) return 'fas fa-file-pdf';
            if (mimeType.includes('word') || mimeType.includes('document')) return 'fas fa-file-word';
            if (mimeType.includes('excel') || mimeType.includes('spreadsheet')) return 'fas fa-file-excel';
            if (mimeType.includes('zip') || mimeType.includes('compressed')) return 'fas fa-file-archive';
            return 'fas fa-file';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Add CC/BCC fields
        document.querySelector('.add-recipient-btn').addEventListener('click', function() {
            const container = document.getElementById('additionalRecipients');
            container.style.display = container.style.display === 'none' ? 'block' : 'none';
        });

        // More options menu
        document.getElementById('moreOptions').addEventListener('click', function() {
            const menu = document.getElementById('moreOptionsMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });

        // Close alerts
        document.querySelectorAll('.close-alert').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.alert').remove();
            });
        });

        // Auto-hide success message after 5 seconds
        setTimeout(() => {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 300);
            }
        }, 5000);

        // Save draft
        document.getElementById('saveDraft').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('composeForm'));
            formData.append('content', editor.innerHTML);
            
            // Here you would typically send this to a save-draft.php endpoint
            localStorage.setItem('mailDraft', JSON.stringify({
                recipient: document.querySelector('[name="email_receiver"]').value,
                subject: document.querySelector('[name="object"]').value,
                content: editor.innerHTML,
                timestamp: new Date().toISOString()
            }));
            
            alert('Brouillon enregistré !');
        });

        // Discard draft
        document.getElementById('discardDraft').addEventListener('click', function() {
            if (confirm('Voulez-vous vraiment supprimer ce brouillon ?')) {
                localStorage.removeItem('mailDraft');
                window.location.href = 'index.php';
            }
        });

        // Cancel compose
        document.getElementById('cancelCompose').addEventListener('click', function(e) {
            e.preventDefault();
            if (editor.innerHTML.trim() || document.querySelector('[name="email_receiver"]').value) {
                if (confirm('Vous avez des modifications non enregistrées. Voulez-vous vraiment quitter ?')) {
                    window.location.href = 'index.php';
                }
            } else {
                window.location.href = 'index.php';
            }
        });

        // Load draft on page load
        window.addEventListener('load', function() {
            const draft = localStorage.getItem('mailDraft');
            if (draft) {
                try {
                    const draftData = JSON.parse(draft);
                    if (draftData.recipient) {
                        document.querySelector('[name="email_receiver"]').value = draftData.recipient;
                    }
                    if (draftData.subject) {
                        document.querySelector('[name="object"]').value = draftData.subject;
                    }
                    if (draftData.content) {
                        editor.innerHTML = draftData.content;
                    }
                } catch (e) {
                    console.error('Error loading draft:', e);
                }
            }
        });

        // Prevent accidental navigation
        window.addEventListener('beforeunload', function(e) {
            if (editor.innerHTML.trim() || document.querySelector('[name="email_receiver"]').value) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Auto-save every 30 seconds
        setInterval(() => {
            if (editor.innerHTML.trim() || document.querySelector('[name="email_receiver"]').value) {
                localStorage.setItem('mailAutoSave', JSON.stringify({
                    recipient: document.querySelector('[name="email_receiver"]').value,
                    subject: document.querySelector('[name="object"]').value,
                    content: editor.innerHTML,
                    timestamp: new Date().toISOString()
                }));
            }
        }, 30000);
    </script>
</body>
</html>
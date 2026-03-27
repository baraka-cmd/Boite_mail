<?php 
require('actions/users_actions/authAction.php');
require('actions/mails_actions/showMailContent.php');
require('actions/mails_actions/publishMailsAction.php');
require('actions/mails_actions/showMailsAnswers.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($mail_title) ? htmlspecialchars($mail_title) : 'Mail'; ?> - Boîte Mail</title>
    <link rel="stylesheet" href="style/mail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="mail-container">
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
                    <span>Envoyés</span>
                </a>
                <a href="my-mails.php" class="nav-item">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Mes mails</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-star"></i>
                    <span>Importants</span>
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
            <header class="mail-header">
                <div class="header-left">
                    <a href="index.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="mail-actions">
                        <button class="action-btn" title="Archiver">
                            <i class="fas fa-archive"></i>
                        </button>
                        <button class="action-btn" title="Signaler comme spam">
                            <i class="fas fa-exclamation-circle"></i>
                        </button>
                        <button class="action-btn" title="Supprimer" onclick="if(confirm('Supprimer ce mail ?')) { window.location.href='actions/mails_actions/deleteMail.php?id=<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>'; }">
                            <i class="far fa-trash-alt"></i>
                        </button>
                        <button class="action-btn" title="Marquer comme non lu">
                            <i class="far fa-envelope"></i>
                        </button>
                        <button class="action-btn" title="Plus d'options">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
                <div class="header-right">
                    <span class="mail-count">1 sur <?php echo isset($getAllAnswersOfThisMail) ? $getAllAnswersOfThisMail->rowCount() + 1 : 1; ?></span>
                    <button class="action-btn" title="Précédent">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="action-btn" title="Suivant">
                        <i class="fas fa-chevron-right"></i>
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

            <!-- Mail Content -->
            <div class="mail-content-area">
                <?php if(isset($mail_receiver_email)): ?>
                    <!-- Original Mail -->
                    <div class="mail-card">
                        <div class="mail-header-info">
                            <div class="sender-info">
                                <div class="sender-avatar">
                                    <?php 
                                    $initials = strtoupper(substr($mail_author_lastname, 0, 1) . substr($mail_author_firstname, 0, 1));
                                    echo $initials;
                                    ?>
                                </div>
                                <div class="sender-details">
                                    <div class="sender-name">
                                        <strong><?php echo htmlspecialchars($mail_author_lastname . ' ' . $mail_author_firstname); ?></strong>
                                        <span class="sender-email"><?php echo htmlspecialchars($mail_author_email); ?></span>
                                    </div>
                                    <div class="mail-meta">
                                        <span class="mail-to">à <?php echo htmlspecialchars($mail_receiver_email); ?></span>
                                        <span class="mail-time">
                                            <i class="far fa-clock"></i> 
                                            <?php echo date('d M Y à H:i', strtotime('now')); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mail-actions-top">
                                <button class="mail-action-btn" title="Répondre">
                                    <i class="fas fa-reply"></i>
                                </button>
                                <button class="mail-action-btn" title="Répondre à tous">
                                    <i class="fas fa-reply-all"></i>
                                </button>
                                <button class="mail-action-btn" title="Transférer">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mail-body">
                            <h1 class="mail-subject"><?php echo htmlspecialchars($mail_title); ?></h1>
                            <div class="mail-text">
                                <?php echo nl2br(htmlspecialchars($mail_content)); ?>
                            </div>
                        </div>

                        <div class="mail-footer">
                            <button class="action-btn" title="Imprimer">
                                <i class="fas fa-print"></i> Imprimer
                            </button>
                        </div>
                    </div>

                    <!-- Replies Section -->
                    <?php if($getAllAnswersOfThisMail->rowCount() > 0): ?>
                    <div class="replies-section">
                        <h3 class="replies-title">
                            <i class="fas fa-comments"></i> 
                            <?php echo $getAllAnswersOfThisMail->rowCount(); ?> réponse<?php echo $getAllAnswersOfThisMail->rowCount() > 1 ? 's' : ''; ?>
                        </h3>
                        
                        <?php while($answer = $getAllAnswersOfThisMail->fetch()): ?>
                        <div class="reply-card">
                            <div class="reply-header">
                                <div class="reply-sender">
                                    <div class="reply-avatar">
                                        <?php 
                                        $replyInitials = strtoupper(substr($answer['nom_auteur'], 0, 1) . substr($answer['prenom_auteur'], 0, 1));
                                        echo $replyInitials;
                                        ?>
                                    </div>
                                    <div class="reply-sender-info">
                                        <strong><?php echo htmlspecialchars($answer['nom_auteur'] . ' ' . $answer['prenom_auteur']); ?></strong>
                                        <span class="reply-email"><?php echo htmlspecialchars($answer['email_auteur']); ?></span>
                                    </div>
                                </div>
                                <div class="reply-time">
                                    <i class="far fa-clock"></i> 
                                    <span><?php echo date('d M Y à H:i', strtotime('now')); ?></span>
                                </div>
                            </div>
                            <div class="reply-body">
                                <?php echo nl2br(htmlspecialchars($answer['contenu'])); ?>
                            </div>
                            <div class="reply-actions">
                                <button class="reply-action-btn">
                                    <i class="fas fa-reply"></i> Répondre
                                </button>
                                <button class="reply-action-btn">
                                    <i class="fas fa-thumbs-up"></i> J'aime
                                </button>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Reply Form -->
                    <div class="reply-form-section">
                        <h3 class="reply-form-title">
                            <i class="fas fa-pen"></i> Répondre
                        </h3>
                        <form class="reply-form" method="POST">
                            <div class="reply-to-info">
                                <span class="reply-to-label">À :</span>
                                <span class="reply-to-email"><?php echo htmlspecialchars($mail_author_email); ?></span>
                            </div>
                            <div class="form-group">
                                <textarea 
                                    name="content" 
                                    class="reply-textarea" 
                                    placeholder="Écrivez votre réponse ici..."
                                    rows="8"
                                    required
                                ></textarea>
                            </div>
                            <div class="form-footer">
                                <div class="formatting-tools">
                                    <button type="button" class="format-btn" title="Gras">
                                        <i class="fas fa-bold"></i>
                                    </button>
                                    <button type="button" class="format-btn" title="Italique">
                                        <i class="fas fa-italic"></i>
                                    </button>
                                    <button type="button" class="format-btn" title="Liste">
                                        <i class="fas fa-list-ul"></i>
                                    </button>
                                    <button type="button" class="format-btn" title="Lien">
                                        <i class="fas fa-link"></i>
                                    </button>
                                    <button type="button" class="format-btn" title="Pièce jointe">
                                        <i class="fas fa-paperclip"></i>
                                    </button>
                                </div>
                                <div class="submit-actions">
                                    <button type="button" class="btn-cancel" onclick="window.history.back()">
                                        Annuler
                                    </button>
                                    <button type="submit" name="validate" class="btn-send-reply">
                                        <i class="fas fa-paper-plane"></i> Envoyer la réponse
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                <?php else: ?>
                    <!-- No Mail Found -->
                    <div class="no-mail">
                        <div class="no-mail-icon">
                            <i class="fas fa-envelope-open"></i>
                        </div>
                        <h2>Aucun mail trouvé</h2>
                        <p>Le mail que vous essayez de consulter n'existe pas ou vous n'y avez pas accès.</p>
                        <a href="index.php" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Retour à la boîte de réception
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Formatting tools
        document.querySelectorAll('.format-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const textarea = document.querySelector('.reply-textarea');
                const tool = this.querySelector('i').className;
                
                if (tool.includes('fa-bold')) {
                    insertText(textarea, '**', '**');
                } else if (tool.includes('fa-italic')) {
                    insertText(textarea, '*', '*');
                } else if (tool.includes('fa-list-ul')) {
                    insertText(textarea, '\n• ', '');
                } else if (tool.includes('fa-link')) {
                    const url = prompt('Entrez l\'URL:', 'https://');
                    if (url) {
                        insertText(textarea, '[', '](' + url + ')');
                    }
                } else if (tool.includes('fa-paperclip')) {
                    alert('Fonctionnalité de pièce jointe à implémenter');
                }
            });
        });

        function insertText(textarea, startTag, endTag) {
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            const newText = startTag + selectedText + endTag;
            
            textarea.value = textarea.value.substring(0, start) + newText + textarea.value.substring(end);
            textarea.focus();
            textarea.setSelectionRange(start + startTag.length, start + startTag.length + selectedText.length);
        }

        // Auto-hide error message
        setTimeout(() => {
            const errorAlert = document.querySelector('.alert-error');
            if (errorAlert) {
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.style.display = 'none', 300);
            }
        }, 5000);

        // Reply action buttons
        document.querySelectorAll('.mail-action-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.querySelector('i').className;
                if (action.includes('fa-reply')) {
                    document.querySelector('.reply-textarea').focus();
                } else if (action.includes('fa-reply-all')) {
                    alert('Répondre à tous');
                } else if (action.includes('fa-share')) {
                    alert('Transférer');
                }
            });
        });

        // Print functionality
        document.querySelector('[title="Imprimer"]').addEventListener('click', function() {
            window.print();
        });

        // Responsive sidebar toggle for mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('mobile-show');
        }
    </script>
</body>
</html>
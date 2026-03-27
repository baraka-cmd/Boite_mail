<?php 
require('actions/users_actions/authAction.php');
require('actions/mails_actions/receivedMailsAction.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boîte de réception - Boîte Mail</title>
    <link rel="stylesheet" href="style/inbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Main Container -->
    <div class="gmail-container">
        
        <!-- Sidebar Navigation -->
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
                <a href="index.php" class="nav-item active">
                    <i class="fas fa-inbox"></i>
                    <span>Boîte de réception</span>
                    <?php if($getReceivedMails->rowCount() > 0): ?>
                    <span class="badge"><?php echo $getReceivedMails->rowCount(); ?></span>
                    <?php endif; ?>
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
                <a href="#" class="nav-item">
                    <i class="fas fa-clock"></i>
                    <span>Reportés</span>
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
            <!-- Top Bar -->
            <header class="top-bar">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher dans les mails" id="searchInput">
                </div>
                <div class="top-bar-actions">
                    <button class="action-btn" title="Actualiser" onclick="location.reload()">
                        <i class="fas fa-redo"></i>
                    </button>
                    <button class="action-btn" title="Paramètres">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <div class="mail-header">
                    <h2><i class="fas fa-inbox"></i> Boîte de réception</h2>
                    <div class="mail-filters">
                        <button class="filter-btn active">Principal</button>
                        <button class="filter-btn">Social</button>
                        <button class="filter-btn">Promotions</button>
                    </div>
                </div>

                <!-- Mails List -->
                <div class="mails-list">
                    <?php if($getReceivedMails->rowCount() > 0): ?>
                        <?php while($mail = $getReceivedMails->fetch()): ?>
                        <div class="mail-item" onclick="window.location.href='mail.php?id=<?php echo $mail['id']; ?>'">
                            <div class="mail-select">
                                <input type="checkbox" class="mail-checkbox">
                            </div>
                            <div class="mail-sender">
                                <div class="sender-avatar">
                                    <?php 
                                    $authorEmail = htmlspecialchars($mail['email_auteur']);
                                    $initials = strtoupper(substr($authorEmail, 0, 1));
                                    echo $initials;
                                    ?>
                                </div>
                                <span class="sender-name"><?php echo htmlspecialchars($mail['email_auteur']); ?></span>
                            </div>
                            <div class="mail-content">
                                <div class="mail-title">
                                    <strong><?php echo htmlspecialchars($mail['titre']); ?></strong>
                                    <?php if(strlen($mail['contenu']) > 100): ?>
                                    <span class="mail-preview"> - <?php echo htmlspecialchars(substr(strip_tags($mail['contenu']), 0, 100)) . '...'; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="mail-time">
                                    <i class="far fa-clock"></i> 
                                    <span><?php echo date('H:i', strtotime('now')); ?></span>
                                </div>
                            </div>
                            <div class="mail-actions">
                                <button class="mail-action-btn" title="Marquer comme important">
                                    <i class="far fa-star"></i>
                                </button>
                                <button class="mail-action-btn" title="Archiver">
                                    <i class="fas fa-archive"></i>
                                </button>
                                <button class="mail-action-btn" title="Supprimer" onclick="event.stopPropagation(); if(confirm('Supprimer ce mail ?')) { window.location.href='actions/mails_actions/deleteMail.php?id=<?php echo $mail['id']; ?>'; }">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <!-- Empty State -->
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-envelope-open"></i>
                            </div>
                            <h3>Votre boîte de réception est vide</h3>
                            <p>Lorsque vous recevrez des mails, ils apparaîtront ici.</p>
                            <button class="compose-empty-btn" onclick="window.location.href='send-mail.php'">
                                <i class="fas fa-pen"></i> Rédiger un mail
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if($getReceivedMails->rowCount() > 0): ?>
                <div class="pagination">
                    <button class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i> Précédent
                    </button>
                    <span class="page-info">1 sur 1</span>
                    <button class="pagination-btn">
                        Suivant <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </main>

        <!-- Right Sidebar (Optional) -->
        <aside class="right-sidebar">
            <div class="quick-settings">
                <h4>Réglages rapides</h4>
                <div class="setting-item">
                    <span>Densité d'affichage</span>
                    <select class="density-select">
                        <option>Par défaut</option>
                        <option>Confortable</option>
                        <option>Compacte</option>
                    </select>
                </div>
                <div class="setting-item">
                    <span>Thème</span>
                    <select class="theme-select">
                        <option>Clair</option>
                        <option>Sombre</option>
                        <option>Système</option>
                    </select>
                </div>
            </div>

            <div class="calendar-widget">
                <h4>Calendrier</h4>
                <div class="calendar-header">
                    <button><i class="fas fa-chevron-left"></i></button>
                    <span><?php echo date('F Y'); ?></span>
                    <button><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="calendar-grid">
                    <!-- Simple calendar grid would go here -->
                    <div class="calendar-day today"><?php echo date('j'); ?></div>
                </div>
            </div>
        </aside>
    </div>

    <!-- JavaScript -->
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const mailItems = document.querySelectorAll('.mail-item');
            
            mailItems.forEach(item => {
                const title = item.querySelector('.mail-title').textContent.toLowerCase();
                const sender = item.querySelector('.sender-name').textContent.toLowerCase();
                const preview = item.querySelector('.mail-preview')?.textContent.toLowerCase() || '';
                
                if (title.includes(searchTerm) || sender.includes(searchTerm) || preview.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Mail item selection
        document.querySelectorAll('.mail-checkbox').forEach(checkbox => {
            checkbox.addEventListener('click', function(e) {
                e.stopPropagation();
                this.closest('.mail-item').classList.toggle('selected');
            });
        });

        // Mark as important
        document.querySelectorAll('.mail-action-btn .fa-star').forEach(star => {
            star.addEventListener('click', function(e) {
                e.stopPropagation();
                this.classList.toggle('far');
                this.classList.toggle('fas');
                this.classList.toggle('active');
            });
        });

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Responsive sidebar toggle (for mobile)
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('mobile-show');
        }

        // Auto refresh every 30 seconds
        setInterval(() => {
            // You could add AJAX refresh here
            console.log('Auto-refresh...');
        }, 30000);

        // Handle empty state
        const mailItems = document.querySelectorAll('.mail-item');
        if (mailItems.length === 0) {
            document.querySelector('.pagination').style.display = 'none';
        }
    </script>
</body>
</html>
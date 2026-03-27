<?php
require('actions/users_actions/authAction.php');
require('actions/mails_actions/myMailsAction.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mails envoyés - Boîte Mail</title>
    <link rel="stylesheet" href="style/my-mails.css">
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
                <a href="index.php" class="nav-item">
                    <i class="fas fa-inbox"></i>
                    <span>Boîte de réception</span>
                </a>
                <a href="send-mail.php" class="nav-item">
                    <i class="fas fa-paper-plane"></i>
                    <span>Envoyer un mail</span>
                </a>
                <a href="my-mails.php" class="nav-item active">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Mails envoyés</span>
                    <?php if($getAllSentMails->rowCount() > 0): ?>
                    <span class="badge"><?php echo $getAllSentMails->rowCount(); ?></span>
                    <?php endif; ?>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-star"></i>
                    <span>Brouillons</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-trash"></i>
                    <span>Corbeille</span>
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
                <div class="top-bar-left">
                    <h1 class="page-title">
                        <i class="fas fa-envelope-open-text"></i> Mails envoyés
                    </h1>
                    <p class="page-subtitle">Retrouvez tous les mails que vous avez envoyés</p>
                </div>
                <div class="top-bar-right">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Rechercher dans les mails envoyés" id="searchInput">
                    </div>
                    <div class="top-bar-actions">
                        <button class="action-btn" title="Actualiser" onclick="location.reload()">
                            <i class="fas fa-redo"></i>
                        </button>
                        <div class="dropdown">
                            <button class="action-btn" title="Trier">
                                <i class="fas fa-sort-amount-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="#" class="dropdown-item" data-sort="newest">Plus récents</a>
                                <a href="#" class="dropdown-item" data-sort="oldest">Plus anciens</a>
                                <a href="#" class="dropdown-item" data-sort="recipient">Par destinataire</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <div class="bulk-actions-left">
                    <div class="select-all">
                        <input type="checkbox" id="selectAll">
                        <label for="selectAll">Tout sélectionner</label>
                    </div>
                    <span class="selected-count" id="selectedCount">0 sélectionnés</span>
                </div>
                <div class="bulk-actions-right">
                    <button class="bulk-btn" title="Archiver" id="bulkArchive">
                        <i class="fas fa-archive"></i>
                    </button>
                    <button class="bulk-btn bulk-danger" title="Supprimer" id="bulkDelete">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    <button class="bulk-btn" title="Marquer comme important" id="bulkImportant">
                        <i class="far fa-star"></i>
                    </button>
                    <button class="bulk-btn" title="Marquer comme non lu" id="bulkUnread">
                        <i class="far fa-envelope"></i>
                    </button>
                </div>
            </div>

            <!-- Mails List -->
            <div class="mails-list">
                <?php if($getAllSentMails->rowCount() > 0): ?>
                    <?php while($mail = $getAllSentMails->fetch()): ?>
                    <div class="mail-item" data-mail-id="<?php echo $mail['id']; ?>">
                        <div class="mail-select">
                            <input type="checkbox" class="mail-checkbox" data-id="<?php echo $mail['id']; ?>">
                        </div>
                        <div class="mail-content" onclick="window.location.href='mail.php?id=<?php echo $mail['id']; ?>'">
                            <div class="mail-sender">
                                <div class="sender-avatar sent">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <div class="sender-info">
                                    <strong class="sender-name">À : <?php echo htmlspecialchars($mail['email_destinataire']); ?></strong>
                                    <div class="mail-subject">
                                        <strong><?php echo htmlspecialchars($mail['titre']); ?></strong>
                                        <?php if(isset($mail['contenu']) && strlen($mail['contenu']) > 100): ?>
                                        <span class="mail-preview"> - <?php echo htmlspecialchars(substr(strip_tags($mail['contenu']), 0, 100)) . '...'; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mail-time">
                                <i class="far fa-clock"></i>
                                <span><?php echo date('d M H:i', strtotime('now')); ?></span>
                            </div>
                        </div>
                        <div class="mail-actions">
                            <button class="mail-action-btn" title="Réenvoyer" onclick="window.location.href='send-mail.php?reply=<?php echo $mail['id']; ?>'">
                                <i class="fas fa-redo"></i>
                            </button>
                            <button class="mail-action-btn" title="Modifier" onclick="window.location.href='edit-mail.php?id=<?php echo $mail['id']; ?>'">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="mail-action-btn mail-action-danger" title="Supprimer" onclick="deleteMail(<?php echo $mail['id']; ?>)">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <h3>Aucun mail envoyé</h3>
                        <p>Vous n'avez pas encore envoyé de mails. Rédigez votre premier mail !</p>
                        <button class="compose-empty-btn" onclick="window.location.href='send-mail.php'">
                            <i class="fas fa-pen"></i> Rédiger un mail
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if($getAllSentMails->rowCount() > 0): ?>
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
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const mailItems = document.querySelectorAll('.mail-item');
            
            mailItems.forEach(item => {
                const recipient = item.querySelector('.sender-name').textContent.toLowerCase();
                const subject = item.querySelector('.mail-subject strong').textContent.toLowerCase();
                const preview = item.querySelector('.mail-preview')?.textContent.toLowerCase() || '';
                
                if (recipient.includes(searchTerm) || subject.includes(searchTerm) || preview.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Mail selection
        const selectAllCheckbox = document.getElementById('selectAll');
        const mailCheckboxes = document.querySelectorAll('.mail-checkbox');
        const selectedCount = document.getElementById('selectedCount');
        const bulkActions = document.getElementById('bulkActions');

        function updateSelection() {
            const selected = document.querySelectorAll('.mail-checkbox:checked');
            const count = selected.length;
            
            selectedCount.textContent = count + ' sélectionné' + (count > 1 ? 's' : '');
            
            // Show/hide bulk actions
            if (count > 0) {
                bulkActions.style.display = 'flex';
                selectAllCheckbox.indeterminate = count > 0 && count < mailCheckboxes.length;
            } else {
                bulkActions.style.display = 'none';
                selectAllCheckbox.indeterminate = false;
            }
            
            // Update select all state
            selectAllCheckbox.checked = count === mailCheckboxes.length;
        }

        // Select all functionality
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            mailCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateSelection();
        });

        // Individual checkbox selection
        mailCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelection);
        });

        // Bulk actions
        document.getElementById('bulkDelete').addEventListener('click', function() {
            const selected = Array.from(document.querySelectorAll('.mail-checkbox:checked'))
                .map(cb => cb.getAttribute('data-id'));
            
            if (selected.length === 0) {
                alert('Veuillez sélectionner au moins un mail');
                return;
            }
            
            if (confirm(`Supprimer ${selected.length} mail(s) ?`)) {
                // Send bulk delete request
                selected.forEach(id => {
                    fetch(`actions/mails_actions/deleteMail.php?id=${id}`, {
                        method: 'GET',
                        credentials: 'same-origin'
                    }).then(() => {
                        location.reload();
                    });
                });
            }
        });

        document.getElementById('bulkArchive').addEventListener('click', function() {
            const selected = Array.from(document.querySelectorAll('.mail-checkbox:checked'))
                .map(cb => cb.getAttribute('data-id'));
            
            if (selected.length === 0) {
                alert('Veuillez sélectionner au moins un mail');
                return;
            }
            
            alert(`${selected.length} mail(s) archivés (fonctionnalité à implémenter)`);
            // Implement archive functionality here
        });

        document.getElementById('bulkImportant').addEventListener('click', function() {
            const selected = Array.from(document.querySelectorAll('.mail-checkbox:checked'))
                .map(cb => cb.closest('.mail-item'));
            
            selected.forEach(item => {
                const star = item.querySelector('.mail-action-btn .fa-star');
                if (star) {
                    star.classList.toggle('far');
                    star.classList.toggle('fas');
                    star.classList.toggle('active');
                }
            });
        });

        // Individual mail delete
        function deleteMail(mailId) {
            if (confirm('Supprimer ce mail ?')) {
                window.location.href = `actions/mails_actions/deleteMail.php?id=${mailId}`;
            }
        }

        // Sort functionality
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const sortType = this.getAttribute('data-sort');
                alert(`Tri par : ${sortType} (fonctionnalité à implémenter)`);
                // Implement sort functionality here
            });
        });

        // Dropdown toggle
        document.querySelector('.dropdown .action-btn').addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelector('.dropdown-menu').classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            document.querySelector('.dropdown-menu').classList.remove('show');
        });

        // Hide bulk actions by default
        bulkActions.style.display = 'none';
    </script>
</body>
</html>
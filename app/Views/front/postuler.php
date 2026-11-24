<?php
$pageTitle   = 'Mahara | Postuler';
$currentPage = 'postuler';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
<?php require_once __DIR__ . '/includes/head.php'; ?>
</head>

<body>
<?php require_once __DIR__ . '/includes/spinner.php'; ?>
<?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <!-- ========== Contenu spécifique de la page : début ========== -->

    <!-- Header Start -->
    <section class="page-header">
        <div class="container">
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=missions">Missions</a></li><li>Postuler</li></ol>
            <h1>Postuler à une mission</h1>
            <p>Présente-toi au client et propose ton prix.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <div class="detail-grid">
                <form class="card" action="#" method="post">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">
                    <h3 style="margin-bottom:20px">Ta candidature</h3>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="message">Message au client</label>
                            <textarea id="message" name="message" class="form-control" required placeholder="Pourquoi toi ? Tes expériences proches, ton organisation, le délai que tu proposes…"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="prix">Prix proposé (TND)</label>
                            <input id="prix" name="prix_propose" type="number" min="0" step="0.5" class="form-control" value="80" required>
                            <span class="form-help">Budget du client : 80 TND</span>
                        </div>
                    </div>
                    <label class="check" style="margin-top:18px"><input type="checkbox" name="joindre_portfolio" checked> Joindre mon portfolio Mahara</label>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Envoyer ma candidature</button>
                        <a href="index.php?page=missions" class="btn btn-outline">Annuler</a>
                    </div>
                </form>
                <aside class="card">
                    <span class="badge">Traduction</span>
                    <h3 style="margin:12px 0 8px">Traduire une plaquette de 4 pages</h3>
                    <p class="text-muted" style="margin-bottom:16px">Plaquette de 4 pages, français vers anglais.</p>
                    <div class="info-row"><span>Budget</span><strong>80 TND</strong></div>
                    <div class="info-row"><span>Délai</span><strong>4 jours</strong></div>
                    <div class="info-row"><span>Ville</span><strong>Tunis</strong></div>
                    <div class="info-row"><span>Client</span><strong>Karim Ben Salah</strong></div>
                    <p class="form-help" style="margin-top:16px">Le paiement est bloqué par Mahara quand ta candidature est acceptée, puis versé à la livraison.</p>
                </aside>
            </div>
        </div>
    </section>
    <!-- Form End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>

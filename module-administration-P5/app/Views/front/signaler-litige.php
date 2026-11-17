<?php
$pageTitle   = 'Mahara | Signaler un litige';
$currentPage = 'signaler-litige';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Signaler un litige</li></ol>
            <h1>Signaler un litige</h1>
            <p>Un problème avec une mission ou un paiement ? L'équipe Mahara examine chaque demande.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <form class="card form-card" action="#" method="post">
                <h3 style="margin-bottom:20px">Ton signalement</h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="mission">Mission concernée</label>
                        <select id="mission" name="id_paiement" class="form-control" required>
                            <option value="">Choisir…</option>
                            <option>Créer la page Facebook d'une pâtisserie · 120 TND</option>
                            <option>Logo pour une pâtisserie · 90 TND</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label for="motif">Motif</label>
                        <select id="motif" name="motif" class="form-control" required>
                            <option value="">Choisir…</option>
                            <option>Livraison en retard</option>
                            <option>Travail incomplet ou non conforme</option>
                            <option>Paiement non libéré</option>
                            <option>Comportement inapproprié</option>
                            <option>Autre</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label for="description">Explique la situation</label>
                        <textarea id="description" name="description" class="form-control" required placeholder="Dates, échanges avec l'autre personne, ce que tu attends…"></textarea>
                        <span class="form-help">Pendant l'examen du litige, le paiement de la mission reste bloqué.</span>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Envoyer le signalement</button>
                    <a href="index.php?page=accueil" class="btn btn-outline">Annuler</a>
                </div>
            </form>
        </div>
    </section>
    <!-- Form End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>

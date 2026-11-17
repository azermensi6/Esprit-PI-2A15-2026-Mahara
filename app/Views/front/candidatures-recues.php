<?php
$pageTitle   = 'Mahara | Candidatures reçues';
$currentPage = 'candidatures-recues';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=mes-missions">Mes missions</a></li><li>Candidatures reçues</li></ol>
            <h1>Candidatures reçues</h1>
            <p>Mission : Créer la page Facebook d'une pâtisserie · budget 120 TND</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- List Start -->
    <section class="section">
        <div class="container" style="max-width:920px">
            <div class="result-bar"><span>2 candidatures</span>
                <label for="f-mission" style="position:absolute;left:-9999px">Mission</label>
                <select id="f-mission" class="form-control" style="width:auto"><option>Créer la page Facebook d'une pâtisserie</option><option>Logo pour une pâtisserie</option><option>Site vitrine pour un cabinet</option><option>Traduire une plaquette</option></select>
            </div>
            <div class="stack">
                <article class="card candidate-card">
                    <span class="avatar">OM</span>
                    <div class="candidate-body">
                        <div class="top"><h3>Omar Mansour</h3><span class="badge badge-green">Acceptée</span></div>
                        <p class="text-muted">« Je gère déjà la page d'une boutique, voir mon portfolio. »</p>
                        <div class="meta"><span>Prix proposé : <strong>120 TND</strong></span><span>09/11/2026</span><a href="index.php?page=portfolio">Voir le portfolio</a></div>
                    </div>
                    <div class="card-actions"><span class="badge badge-orange">Paiement bloqué</span></div>
                </article>
                <article class="card candidate-card">
                    <span class="avatar">YB</span>
                    <div class="candidate-body">
                        <div class="top"><h3>Yasmine Ben Ali</h3><span class="badge badge-red">Refusée</span></div>
                        <p class="text-muted">« Je propose aussi des photos des gâteaux. »</p>
                        <div class="meta"><span>Prix proposé : <strong>110 TND</strong></span><span>10/11/2026</span><a href="index.php?page=portfolio">Voir le portfolio</a></div>
                    </div>
                    <div class="card-actions"></div>
                </article>
                <article class="card candidate-card">
                    <span class="avatar">MT</span>
                    <div class="candidate-body">
                        <div class="top"><h3>Mehdi Trabelsi</h3><span class="badge">En attente</span></div>
                        <p class="text-muted">« J'ai déjà animé la page Instagram du club de mon université. »</p>
                        <div class="meta"><span>Prix proposé : <strong>100 TND</strong></span><span>11/11/2026</span><a href="index.php?page=portfolio">Voir le portfolio</a></div>
                    </div>
                    <div class="card-actions"><a href="index.php?page=payer" class="btn btn-primary btn-sm">Accepter et payer</a><button type="button" class="btn btn-outline btn-sm">Refuser</button></div>
                </article>
            </div>
        </div>
    </section>
    <!-- List End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>

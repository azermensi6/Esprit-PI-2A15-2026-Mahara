<?php
$pageTitle   = 'Mahara | Mes candidatures';
$currentPage = 'mes-candidatures';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Mes candidatures</li></ol>
            <h1>Mes candidatures</h1>
            <p>Suis l'état de tes candidatures et de tes paiements.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Table Start -->
    <section class="section">
        <div class="container">
            <div class="grid grid-4" style="margin-bottom:28px">
                <div class="card stat-card"><span>Envoyées</span><strong>3</strong></div>
                <div class="card stat-card"><span>Acceptées</span><strong>1</strong></div>
                <div class="card stat-card"><span>Paiement bloqué</span><strong>120 TND</strong></div>
                <div class="card stat-card"><span>Déjà reçu</span><strong class="text-blue">90 TND</strong></div>
            </div>
            <div class="card table-card">
                <table class="data-table">
                    <thead><tr><th>Mission</th><th>Prix proposé</th><th>Date</th><th>Candidature</th><th>Paiement</th><th></th></tr></thead>
                    <tbody>
                        <tr>
                            <td><strong>Créer la page Facebook d'une pâtisserie</strong><small>Nour Gharbi · La Marsa</small></td>
                            <td class="nowrap"><strong>120 TND</strong></td><td class="nowrap">09/11/2026</td>
                            <td><span class="badge badge-green">Acceptée</span></td>
                            <td><span class="badge badge-orange">Bloqué</span></td>
                            <td><div class="card-actions"><button type="button" class="btn btn-blue btn-sm">Marquer comme livrée</button></div></td>
                        </tr>
                        <tr>
                            <td><strong>Traduire une plaquette</strong><small>Karim Ben Salah · Tunis</small></td>
                            <td class="nowrap"><strong>80 TND</strong></td><td class="nowrap">14/11/2026</td>
                            <td><span class="badge">En attente</span></td>
                            <td class="text-muted">—</td>
                            <td><div class="card-actions"><button type="button" class="btn btn-outline btn-sm btn-danger" data-confirm="Retirer cette candidature ?">Retirer</button></div></td>
                        </tr>
                        <tr>
                            <td><strong>Logo pour une pâtisserie</strong><small>Nour Gharbi · La Marsa</small></td>
                            <td class="nowrap"><strong>90 TND</strong></td><td class="nowrap">21/10/2026</td>
                            <td><span class="badge badge-outline">Livrée</span></td>
                            <td><span class="badge badge-green">Libéré</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- Table End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>

<?php
$pageTitle   = 'Mahara | Mes missions';
$currentPage = 'mes-missions';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Mes missions</li></ol>
            <h1>Mes missions</h1>
            <p>Suis les missions que tu as publiées et les candidatures reçues.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Table Start -->
    <section class="section">
        <div class="container">
            <div class="section-head"><div><h2>4 missions publiées</h2><p>2 ouvertes · 1 en cours · 1 terminée</p></div><a href="index.php?page=publier-mission" class="btn btn-primary"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Publier une mission</a></div>
            <div class="card table-card">
                <table class="data-table">
                    <thead><tr><th>Mission</th><th>Catégorie</th><th>Budget</th><th>Candidatures</th><th>Statut</th><th></th></tr></thead>
                    <tbody>
                        <tr>
                            <td><strong>Site vitrine pour un cabinet</strong><small>Tunis · 15 jours · publiée le 12/11/2026</small></td>
                            <td>Développement web</td><td class="nowrap"><strong>600 TND</strong></td><td>1</td>
                            <td><span class="badge">Ouverte</span></td>
                            <td><div class="card-actions"><a href="index.php?page=candidatures-recues" class="btn btn-blue btn-sm">Candidatures</a><a href="index.php?page=publier-mission" class="btn btn-outline btn-sm">Modifier</a></div></td>
                        </tr>
                        <tr>
                            <td><strong>Traduire une plaquette</strong><small>Tunis · 4 jours · publiée le 13/11/2026</small></td>
                            <td>Traduction</td><td class="nowrap"><strong>80 TND</strong></td><td>1</td>
                            <td><span class="badge">Ouverte</span></td>
                            <td><div class="card-actions"><a href="index.php?page=candidatures-recues" class="btn btn-blue btn-sm">Candidatures</a><a href="index.php?page=publier-mission" class="btn btn-outline btn-sm">Modifier</a></div></td>
                        </tr>
                        <tr>
                            <td><strong>Créer la page Facebook d'une pâtisserie</strong><small>La Marsa · 3 jours · publiée le 08/11/2026</small></td>
                            <td>Réseaux sociaux</td><td class="nowrap"><strong>120 TND</strong></td><td>2</td>
                            <td><span class="badge badge-orange">En cours</span></td>
                            <td><div class="card-actions"><a href="index.php?page=candidatures-recues" class="btn btn-outline btn-sm">Voir</a></div></td>
                        </tr>
                        <tr>
                            <td><strong>Logo pour une pâtisserie</strong><small>La Marsa · 5 jours · publiée le 20/10/2026</small></td>
                            <td>Design</td><td class="nowrap"><strong>90 TND</strong></td><td>1</td>
                            <td><span class="badge badge-green">Terminée</span></td>
                            <td><div class="card-actions"><a href="index.php?page=candidatures-recues" class="btn btn-outline btn-sm">Voir</a></div></td>
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

<?php
$pageTitle   = 'Mahara | Détail de la formation';
$currentPage = 'formation-detail';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=formations">Formations</a></li><li>Détail de la formation</li></ol>
            <h1>PHP et MySQL pour débutants</h1>
            <p>Développement web · débutant · 30 heures · hybride</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Detail Start -->
    <section class="section">
        <div class="container">
            <div class="detail-grid">
                <article class="card">
                    <div class="tag-list" style="margin-bottom:18px"><span class="badge">Développement web</span><span class="badge badge-green">Débutant</span><span class="badge badge-outline">Hybride</span></div>
                    <h3 style="margin-bottom:10px">Description</h3>
                    <p class="text-muted" style="margin-bottom:20px">Construire un site dynamique pas à pas : formulaires, base de données MySQL, connexion des utilisateurs. Idéal avant tes premières missions de développement web.</p>
                    <h3 style="margin-bottom:10px">Programme</h3>
                    <ul class="text-muted" style="margin:0 0 20px 18px">
                        <li>Rappels HTML et CSS, structure d'un projet PHP</li>
                        <li>Variables, conditions, boucles et fonctions</li>
                        <li>Formulaires et validation des données</li>
                        <li>Base de données MySQL avec PDO : lire, ajouter, modifier, supprimer</li>
                        <li>Mini-projet : un site vitrine avec formulaire de contact</li>
                    </ul>
                    <h3 style="margin-bottom:10px">Prérequis</h3>
                    <p class="text-muted">Savoir utiliser un ordinateur et un navigateur. Aucune expérience en programmation n'est demandée.</p>
                </article>
                <aside class="card">
                    <div class="info-row"><span>Prix</span><strong>60 TND</strong></div>
                    <div class="info-row"><span>Durée</span><strong>30 heures</strong></div>
                    <div class="info-row"><span>Mode</span><strong>Hybride</strong></div>
                    <div class="info-row"><span>Niveau</span><strong>Débutant</strong></div>
                    <div class="info-row"><span>Date de début</span><strong>05/12/2026</strong></div>
                    <p class="form-help" style="margin-top:16px">Ajoute ensuite ton mini-projet à ton portfolio pour le montrer aux clients.</p>
                    <a href="index.php?page=formations" class="btn btn-outline btn-block" style="margin-top:16px">Retour aux formations</a>
                </aside>
            </div>
        </div>
    </section>
    <!-- Detail End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>

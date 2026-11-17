<?php
$pageTitle   = 'Mahara | Page introuvable';
$currentPage = '404';
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

    <!-- 404 Start -->
    <section class="error-page">
        <div class="container">
            <div class="code">404</div>
            <h2 style="margin:10px 0 12px">Page introuvable</h2>
            <p class="text-muted" style="margin-bottom:26px">La page que tu cherches n'existe pas ou a été déplacée.</p>
            <a href="index.php?page=accueil" class="btn btn-primary">Retour à l'accueil</a>
        </div>
    </section>
    <!-- 404 End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>

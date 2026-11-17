<?php
$pageTitle   = 'Mahara | Formations';
$currentPage = 'formations';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Formations</li></ol>
            <h1>Formations</h1>
            <p>Des formations courtes pour progresser dans tes compétences et décrocher plus de missions.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Listing Start -->
    <section class="section">
        <div class="container">
            <div class="listing">
                <form class="card filters" action="index.php" method="get">
                    <input type="hidden" name="page" value="formations">
                    <h3>Rechercher</h3>
                    <div class="form-group">
                        <label for="f-q">Mot-clé</label>
                        <input id="f-q" name="q" type="search" class="form-control" placeholder="Ex. PHP, Canva">
                    </div>
                    <div class="form-group">
                        <label for="f-cat">Catégorie</label>
                        <select id="f-cat" name="categorie" class="form-control"><option value="">Toutes</option><option value="1">Design</option><option value="2">Développement web</option><option value="3">Marketing digital</option><option value="4">Langues</option></select>
                    </div>
                    <div class="form-group">
                        <span style="font-weight:800;font-size:14px">Niveau</span>
                        <label class="check"><input type="checkbox" name="niveau[]" value="debutant"> Débutant</label>
                        <label class="check"><input type="checkbox" name="niveau[]" value="intermediaire"> Intermédiaire</label>
                        <label class="check"><input type="checkbox" name="niveau[]" value="avance"> Avancé</label>
                    </div>
                    <div class="form-group">
                        <label for="f-mode">Mode</label>
                        <select id="f-mode" name="mode" class="form-control"><option value="">Tous</option><option value="en_ligne">En ligne</option><option value="presentiel">Présentiel</option><option value="hybride">Hybride</option></select>
                    </div>
                    <div class="form-group">
                        <label for="f-prix">Prix maximum (TND)</label>
                        <input id="f-prix" name="prix_max" type="number" class="form-control" placeholder="Ex. 50" min="0">
                    </div>
                    <button type="submit" class="btn btn-dark btn-block">Rechercher</button>
                </form>
                <div>
                    <div class="result-bar"><span>5 formations trouvées</span>
                        <label for="f-tri" style="position:absolute;left:-9999px">Trier</label>
                        <select id="f-tri" class="form-control" style="width:auto"><option>Prochaines dates</option><option>Prix croissant</option><option>Durée</option></select>
                    </div>
                    <div class="grid grid-2">
                    <article class="card mission-card">
                        <div class="top"><span class="badge">Design</span><span class="price">Gratuite</span></div>
                        <h3>Initiation à Canva et Figma</h3>
                        <div class="meta"><span>Débutant</span><span>12 h</span><span>En ligne</span><span>Début : 01/12/2026</span></div>
                        <a href="index.php?page=formation-detail" class="btn btn-blue btn-sm" style="align-self:flex-start">Voir la formation</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge">Développement web</span><span class="price">60 TND</span></div>
                        <h3>PHP et MySQL pour débutants</h3>
                        <div class="meta"><span>Débutant</span><span>30 h</span><span>Hybride</span><span>Début : 05/12/2026</span></div>
                        <a href="index.php?page=formation-detail" class="btn btn-blue btn-sm" style="align-self:flex-start">Voir la formation</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge">Développement web</span><span class="price">45 TND</span></div>
                        <h3>JavaScript moderne</h3>
                        <div class="meta"><span>Intermédiaire</span><span>24 h</span><span>En ligne</span><span>Début : 10/01/2027</span></div>
                        <a href="index.php?page=formation-detail" class="btn btn-blue btn-sm" style="align-self:flex-start">Voir la formation</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge">Marketing digital</span><span class="price">30 TND</span></div>
                        <h3>Gérer la page Facebook d'un commerce</h3>
                        <div class="meta"><span>Débutant</span><span>8 h</span><span>Présentiel</span><span>Début : 12/12/2026</span></div>
                        <a href="index.php?page=formation-detail" class="btn btn-blue btn-sm" style="align-self:flex-start">Voir la formation</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge">Langues</span><span class="price">40 TND</span></div>
                        <h3>Anglais professionnel</h3>
                        <div class="meta"><span>Intermédiaire</span><span>20 h</span><span>En ligne</span><span>Début : 15/01/2027</span></div>
                        <a href="index.php?page=formation-detail" class="btn btn-blue btn-sm" style="align-self:flex-start">Voir la formation</a>
                    </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Listing End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>

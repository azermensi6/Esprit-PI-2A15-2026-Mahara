<?php
$pageTitle   = 'Mahara | Missions';
$currentPage = 'missions';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Missions</li></ol>
            <h1>Missions disponibles</h1>
            <p>Trouve une mission qui correspond à tes compétences et à ta ville.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Listing Start -->
    <section class="section">
        <div class="container">
            <div class="listing">
                <aside class="card filters">
                    <h3>Filtrer</h3>
                    <div class="form-group">
                        <label for="f-q">Mot-clé</label>
                        <input id="f-q" type="search" class="form-control" placeholder="Ex. logo">
                    </div>
                    <div class="form-group">
                        <span style="font-weight:800;font-size:14px">Catégorie</span>
                        <label class="check"><input type="checkbox" checked> Toutes</label>
                        <label class="check"><input type="checkbox"> Design</label>
                        <label class="check"><input type="checkbox"> Développement web</label>
                        <label class="check"><input type="checkbox"> Réseaux sociaux</label>
                        <label class="check"><input type="checkbox"> Traduction</label>
                        <label class="check"><input type="checkbox"> Cours particuliers</label>
                    </div>
                    <div class="form-group">
                        <label for="f-ville">Ville</label>
                        <select id="f-ville" class="form-control"><option>Toutes</option><option>Tunis</option><option>Ariana</option><option>Sousse</option><option>Sfax</option><option>Nabeul</option></select>
                    </div>
                    <div class="form-group">
                        <label for="f-budget">Budget maximum (TND)</label>
                        <input id="f-budget" type="number" class="form-control" placeholder="Ex. 200" min="0">
                    </div>
                    <button type="button" class="btn btn-dark btn-block">Appliquer</button>
                </aside>
                <div>
                    <div class="result-bar"><span>6 missions trouvées</span>
                        <label for="f-tri" style="position:absolute;left:-9999px">Trier</label>
                        <select id="f-tri" class="form-control" style="width:auto"><option>Plus récentes</option><option>Budget croissant</option><option>Budget décroissant</option></select>
                    </div>
                    <div class="grid grid-2">
                    <article class="card mission-card">
                        <div class="top"><span class="badge ">Réseaux sociaux</span><span class="price">120 TND</span></div>
                        <h3>Créer la page Facebook d'une pâtisserie</h3>
                        <div class="meta"><span>La Marsa</span><span>3 jours</span><span>Débutant</span></div>
                        <a href="index.php?page=postuler" class="btn btn-blue btn-sm" style="align-self:flex-start">Postuler</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge ">Design</span><span class="price">80 TND</span></div>
                        <h3>Logo pour un salon de coiffure</h3>
                        <div class="meta"><span>Sousse</span><span>5 jours</span><span>Débutant</span></div>
                        <a href="index.php?page=postuler" class="btn btn-blue btn-sm" style="align-self:flex-start">Postuler</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge ">Développement</span><span class="price">350 TND</span></div>
                        <h3>Site vitrine pour un artisan potier</h3>
                        <div class="meta"><span>Nabeul</span><span>2 semaines</span><span>Confirmé</span></div>
                        <a href="index.php?page=postuler" class="btn btn-blue btn-sm" style="align-self:flex-start">Postuler</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge ">Traduction</span><span class="price">80 TND</span></div>
                        <h3>Traduire une plaquette de 4 pages</h3>
                        <div class="meta"><span>Tunis</span><span>4 jours</span><span>Intermédiaire</span></div>
                        <a href="index.php?page=postuler" class="btn btn-blue btn-sm" style="align-self:flex-start">Postuler</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge badge-orange">Mission Ville</span><span class="price">150 TND</span></div>
                        <h3>Enquête de terrain sur le tri des déchets</h3>
                        <div class="meta"><span>Sfax</span><span>1 semaine</span><span>Débutant</span></div>
                        <a href="index.php?page=postuler" class="btn btn-blue btn-sm" style="align-self:flex-start">Postuler</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge ">Cours particuliers</span><span class="price">60 TND</span></div>
                        <h3>Soutien en maths pour un élève de 9e</h3>
                        <div class="meta"><span>Ariana</span><span>4 séances</span><span>Intermédiaire</span></div>
                        <a href="index.php?page=postuler" class="btn btn-blue btn-sm" style="align-self:flex-start">Postuler</a>
                    </article>
                    </div>
                    <nav class="pagination" aria-label="Pages"><a href="#" class="active">1</a><a href="#">2</a><a href="#">3</a></nav>
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

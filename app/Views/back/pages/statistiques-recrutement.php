<?php
/**
 * Vue : dashboard statistiques du module P3 · Recrutement (back office).
 * Reçoit (déjà calculé par OffreController::statistiques()) :
 *   $chiffres, $parMois, $topEntreprises, $topVilles, $barresStatut, $enAttente (Entreprise[]),
 *   $expirent (OffreEmploi[]), $joursRestants, $types, $periode, $periodes, $niveaux, $csrfToken
 * Graphiques en HTML/CSS uniquement : aucun script externe (respect de la Content-Security-Policy).
 */
$couleursStatut = ['en_attente' => 'var(--orange)', 'verifiee' => '#2e9e5b', 'refusee' => '#d62828'];
$couleursNiveau = ['fort' => '#2EAD6B', 'moyen' => '#F3852C', 'faible' => '#F6C935'];   // mêmes couleurs que la carte des offres
$pa = $chiffres['part_accessibles'];
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Statistiques recrutement</h2>
                <p>Entreprises et offres d'emploi · données réelles de la base</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Statistiques recrutement</li></ol></nav>
            </div>
          </div>

          <!-- Navigation du module : entreprises / offres / statistiques -->
          <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px">
            <a href="index.php?page=admin-entreprises" class="main-btn light-btn btn-sm">Entreprises</a>
            <a href="index.php?page=admin-offres" class="main-btn light-btn btn-sm">Offres d'emploi</a>
            <a href="index.php?page=admin-statistiques-recrutement" class="main-btn primary-btn btn-sm">Statistiques</a>
          </div>

          <!-- ---------- Filtre par période (métier) ---------- -->
          <div class="card-style mb-30" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;padding:14px 22px">
            <strong style="margin-right:4px">Période :</strong>
            <?php foreach ($periodes as $cle => $libelle): ?>
              <a href="index.php?page=admin-statistiques-recrutement&amp;periode=<?= e($cle) ?>" class="main-btn <?= $cle === $periode ? 'primary-btn' : 'light-btn' ?> btn-sm"<?= $cle === $periode ? ' aria-current="true"' : '' ?>><?= e($libelle) ?></a>
            <?php endforeach; ?>
            <small class="text-muted" style="margin-left:auto;font-weight:600">S'applique aux offres, selon leur date de publication.</small>
          </div>

          <!-- ---------- Chiffres clés ---------- -->
          <div class="row-grid cols-4 mb-30">
            <div class="card-style icon-card"><div class="label">Entreprises</div><div class="value"><?= $chiffres['entreprises'] ?></div><div class="trend <?= $chiffres['en_attente'] > 0 ? '' : 'neutral' ?>"><?= $chiffres['en_attente'] ?> en attente de vérification</div></div>
            <div class="card-style icon-card"><div class="label">Offres actives</div><div class="value blue"><?= $chiffres['actives'] ?></div><div class="trend neutral"><?= $chiffres['visibles'] ?> visibles · <?= $chiffres['accessibles'] ?> accessibles &#9855; · <?= $chiffres['offres'] ?> au total</div></div>
            <div class="card-style icon-card"><div class="label">Part de stages</div><div class="value"><?= $chiffres['part_stages'] ?> %</div><div class="trend neutral">parmi les offres actives</div></div>
            <div class="card-style icon-card"><div class="label">Salaire moyen</div><div class="value"><?= $chiffres['salaire_moyen'] !== null ? number_format($chiffres['salaire_moyen'], 0, ',', ' ') . ' TND' : '—' ?></div><div class="trend neutral">offres actives avec salaire</div></div>
          </div>

          <div class="row-grid cols-wide mb-30">
            <!-- ---------- Offres publiées par mois (colonnes empilées) ---------- -->
            <div class="card-style">
              <div class="card-head"><h3>Offres publiées par mois</h3></div>
              <div style="display:flex;gap:16px;font-size:13px;font-weight:600;margin-bottom:12px">
                <span style="display:flex;align-items:center;gap:6px"><span style="width:12px;height:12px;border-radius:3px;background:var(--blue)"></span><?= e($types['stage']) ?></span>
                <span style="display:flex;align-items:center;gap:6px"><span style="width:12px;height:12px;border-radius:3px;background:var(--orange)"></span><?= e($types['emploi']) ?></span>
              </div>
              <div role="img" aria-label="Nombre d'offres publiées par mois, stages et emplois" style="display:flex;align-items:flex-end;gap:14px;height:200px;padding-top:10px;border-bottom:1px solid #dfe5ef">
                <?php foreach ($parMois as $m): ?>
                  <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;height:100%">
                    <small style="font-weight:800;margin-bottom:4px"><?= $m['stage'] + $m['emploi'] ?></small>
                    <div title="<?= e($types['emploi']) ?> : <?= $m['emploi'] ?>" style="width:60%;max-width:38px;height:<?= $m['hauteur_emploi'] ?>%;background:var(--orange);border-radius:4px 4px 0 0"></div>
                    <div title="<?= e($types['stage']) ?> : <?= $m['stage'] ?>" style="width:60%;max-width:38px;height:<?= $m['hauteur_stage'] ?>%;background:var(--blue);<?= $m['emploi'] === 0 ? 'border-radius:4px 4px 0 0' : 'margin-top:2px' ?>"></div>
                  </div>
                <?php endforeach; ?>
              </div>
              <div style="display:flex;gap:14px;margin-top:8px">
                <?php foreach ($parMois as $m): ?><small class="text-muted" style="flex:1;text-align:center;font-weight:600"><?= e($m['label']) ?></small><?php endforeach; ?>
              </div>
            </div>

            <!-- ---------- Entreprises par statut ---------- -->
            <div class="card-style">
              <div class="card-head"><h3>Entreprises par statut</h3><a href="index.php?page=admin-entreprises">Voir tout</a></div>
              <div class="bars">
                <?php foreach ($barresStatut as $b): ?>
                  <div class="bar-row"><span><?= e($b['nom']) ?></span><div class="bar-track"><div class="bar-fill" style="width:<?= $b['largeur'] ?>%;background:<?= $couleursStatut[$b['statut']] ?>"></div></div><span class="num"><?= $b['nb'] ?></span></div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <div class="row-grid mb-30" style="grid-template-columns:repeat(auto-fit,minmax(280px,1fr))">
            <!-- ---------- Postes accessibles (anneau) ---------- -->
            <div class="card-style">
              <div class="card-head"><h3>Postes accessibles &#9855;</h3><a href="index.php?page=admin-offres&amp;accessible=1">Voir</a></div>
              <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap">
                <div role="img" aria-label="<?= $pa ?> % des offres actives sont accessibles" style="flex:none;width:136px;height:136px;border-radius:50%;background:conic-gradient(var(--blue) 0 <?= $pa ?>%, var(--blue-light) <?= $pa ?>% 100%);display:grid;place-items:center">
                  <div style="width:96px;height:96px;border-radius:50%;background:var(--white);display:grid;place-items:center;font-family:var(--font-title);font-weight:800;font-size:26px;color:var(--navy)"><?= $pa ?> %</div>
                </div>
                <div style="display:grid;gap:8px;font-size:14px;font-weight:700">
                  <span><?= $chiffres['accessibles'] ?> sur <?= $chiffres['actives'] ?> offre(s) active(s)</span>
                  <span class="text-muted"><?= e($types['stage']) ?> : <?= $chiffres['accessibles_stage'] ?> · <?= e($types['emploi']) ?> : <?= $chiffres['accessibles_emploi'] ?></span>
                </div>
              </div>
              <p class="text-muted" style="margin-top:14px;font-size:13px;font-weight:600">Offres ouvertes aux personnes en situation de handicap.</p>
            </div>

            <!-- ---------- Top entreprises ---------- -->
            <div class="card-style">
              <div class="card-head"><h3>Entreprises qui recrutent le plus</h3></div>
              <?php if ($topEntreprises === []): ?><p class="text-muted">Aucune offre active.</p><?php endif; ?>
              <div class="bars">
                <?php foreach ($topEntreprises as $b): ?>
                  <div class="bar-row"><span><?= e($b['nom']) ?></span><div class="bar-track"><div class="bar-fill" style="width:<?= $b['largeur'] ?>%"></div></div><span class="num"><?= $b['nb'] ?></span></div>
                <?php endforeach; ?>
              </div>
              <p class="text-muted" style="margin-top:14px;font-size:13px;font-weight:600">Nombre d'offres actives par entreprise (top 5).</p>
            </div>

            <!-- ---------- Top villes ---------- -->
            <div class="card-style">
              <div class="card-head"><h3>Villes avec le plus d'offres</h3></div>
              <?php if ($topVilles === []): ?><p class="text-muted">Aucune offre active avec une ville.</p><?php endif; ?>
              <div class="bars">
                <?php foreach ($topVilles as $b): ?>
                  <div class="bar-row"><span><?= e($b['nom']) ?></span><div class="bar-track"><div class="bar-fill" style="width:<?= $b['largeur'] ?>%;background:<?= $couleursNiveau[$b['niveau']] ?>"></div></div><span class="num"><?= $b['nb'] ?></span></div>
                <?php endforeach; ?>
              </div>
              <div style="display:flex;gap:14px;flex-wrap:wrap;margin-top:14px;font-size:13px;font-weight:700">
                <?php foreach ($niveaux as $niv => $texte): ?>
                  <span style="display:flex;align-items:center;gap:6px"><span style="width:11px;height:11px;border-radius:50%;background:<?= $couleursNiveau[$niv] ?>"></span><?= e($texte) ?></span>
                <?php endforeach; ?>
              </div>
              <p class="text-muted" style="margin-top:8px;font-size:13px;font-weight:600">Nombre d'offres actives par ville (top 5), mêmes couleurs que la carte.</p>
            </div>
          </div>

          <div class="row-grid cols-2 mb-30">
            <!-- ---------- À traiter : entreprises en attente ---------- -->
            <div class="card-style">
              <div class="card-head"><h3>Entreprises à vérifier (<?= count($enAttente) ?>)</h3><a href="index.php?page=admin-entreprises&amp;statut=en_attente">Voir tout</a></div>
              <?php if ($enAttente === []): ?><p class="text-muted">Aucune entreprise en attente.</p><?php endif; ?>
              <?php foreach (array_slice($enAttente, 0, 5) as $ent): /** @var App\Models\Entreprise $ent */ ?>
                <div class="list-row">
                  <div><strong><?= e($ent->getNom()) ?></strong><small><?= e($ent->getSecteur() ?? '—') ?> · <?= e($ent->getVille() ?? '—') ?> · <?= $ent->getNbOffres() ?> offre(s)</small></div>
                  <form method="post" action="index.php?page=admin-entreprises" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    <input type="hidden" name="id" value="<?= $ent->getId() ?>">
                    <button type="submit" name="action" value="verifier" class="main-btn orange-btn btn-sm" data-confirm="Marquer cette entreprise comme vérifiée ?">Vérifier</button>
                  </form>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- ---------- À traiter : offres qui expirent bientôt ---------- -->
            <div class="card-style">
              <div class="card-head"><h3>Offres qui expirent dans 7 jours (<?= count($expirent) ?>)</h3><a href="index.php?page=admin-offres">Voir tout</a></div>
              <?php if ($expirent === []): ?><p class="text-muted">Aucune offre n'expire cette semaine.</p><?php endif; ?>
              <?php foreach (array_slice($expirent, 0, 5) as $o): /** @var App\Models\OffreEmploi $o */ $j = $joursRestants[$o->getId()]; ?>
                <div class="list-row">
                  <div><strong><a href="index.php?page=admin-offre-form&amp;id=<?= $o->getId() ?>"><?= e($o->getTitre()) ?></a></strong><small><?= e($o->getEntreprise()) ?> · limite le <?= e(dateFr($o->getDateLimite())) ?></small></div>
                  <span class="status-btn <?= $j <= 2 ? 'danger-btn' : 'warning-btn' ?>"><?= $j === 0 ? 'Aujourd\'hui' : $j . ' jour' . ($j > 1 ? 's' : '') ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->

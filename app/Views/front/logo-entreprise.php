<?php
/**
 * Partial : logo rond d'une entreprise (métier avancé « logo de l'entreprise »).
 * À inclure avec require (pas require_once : il peut servir plusieurs fois dans la même page).
 * Attend : $logoNom (string)      nom de l'entreprise
 *          $logoFichier (?string) fichier envoyé par le recruteur, ou null
 *          $logoTaille (int)      diamètre en pixels (ex. 40, 56, 104)
 * Sans fichier : un rond de couleur avec les initiales (Entreprise::initialesDe / couleurDe).
 */
use App\Models\Entreprise;

$logoStyle = 'width:' . $logoTaille . 'px;height:' . $logoTaille . 'px;border-radius:50%;flex:none;';
?>
<?php if ($logoFichier !== null): ?>
<img class="logo-ent" src="<?= e(Entreprise::DOSSIER_LOGOS . '/' . $logoFichier) ?>" alt="Logo de <?= e($logoNom) ?>" width="<?= $logoTaille ?>" height="<?= $logoTaille ?>" style="<?= $logoStyle ?>object-fit:cover;background:#fff" loading="lazy">
<?php else: [$logoFond, $logoTexte] = Entreprise::couleurDe($logoNom); ?>
<span class="logo-ent" aria-hidden="true" style="<?= $logoStyle ?>display:inline-grid;place-items:center;background:<?= $logoFond ?>;color:<?= $logoTexte ?>;font-weight:800;font-size:<?= (int) round($logoTaille * 0.36) ?>px;letter-spacing:.5px;line-height:1"><?= e(Entreprise::initialesDe($logoNom)) ?></span>
<?php endif; ?>

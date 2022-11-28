<div id="navigation">

  <!-- dropdown -->
  <div class="dropdown">
    <button class="dropbtn"><i class='bi bi-pencil'></i> Auteurs</button>
    <div class="dropdown-content">
      <a href="index.php?controleur=ControleurAuteur&action=lireObjets">Tous les auteurs</a>
      <a href="index.php?controleur=ControleurAuteur&action=afficherFormulaireCreationObjet">Créé un Auteur</a>
    </div>
  </div>

  <div class="dropdown">
    <button class="dropbtn"><i class='bi bi-people'></i> Adherents</button>
    <div class="dropdown-content">
      <a href="index.php?controleur=ControleurAdherent&action=lireObjets">Tous les Adherents</a>
      <a href="index.php?controleur=ControleurAdherent&action=afficherFormulaireCreationObjet">Créé un Adherents</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn"><i class="bi bi-book"></i> Livres</button>
    <div class="dropdown-content">
      <a href="index.php?controleur=ControleurLivre&action=lireObjets">Tous les Livres</a>
      <a href="index.php?controleur=ControleurLivre&action=afficherFormulaireCreationObjet">Créé un Livres</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn"><i class='bi bi-person-badge'></i> Genres</button>
    <div class="dropdown-content">
      <a href="index.php?controleur=ControleurGenre&action=lireObjets">Tous les Genres</a>
      <a href="index.php?controleur=ControleurGenre&action=afficherFormulaireCreationObjet">Créé un Genres</a>
    </div>
  </div>

  <div class="dropdown">
    <button class="dropbtn"><i class='bi bi-flag'></i> Nationalites</button>
    <div class="dropdown-content">
      <a href="index.php?controleur=ControleurNationalite&action=lireObjets">Toutes les Nationalites</a>
      <a href="index.php?controleur=ControleurNationalite&action=afficherFormulaireCreationObjet">Créé un Nationalites</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn"><i class='bi bi-tags'></i> Categories</button>
    <div class="dropdown-content">
      <a href="index.php?controleur=ControleurCategorie&action=lireObjets">Toutes les Categories</a>
      <a href="index.php?controleur=ControleurCategorie&action=afficherFormulaireCreationObjet">Créé un Categories</a>
    </div>
  </div>

  <?php
  if ($_SESSION["login"]) :
    $adherent = Adherent::getObjetById($_SESSION["login"]);
    $nom = $adherent->get("nomAdherent");
    $prenom = $adherent->get("prenomAdherent");
  ?>
    <div class="dropdown">
      <button class="dropbtn"><i class="bi bi-box-arrow-in-right"></i> <?= $nom ?> <?= $prenom ?> </button>
      <div class="dropdown-content">
        <a href='index.php?controleur=ControleurAdherent&action=deconnecterAdherent'><i class='bi bi-box-arrow-in-right'></i> Se deconnecter</a>
      </div>
    </div>
  <?php endif;   ?>
</div>

<div id="results">
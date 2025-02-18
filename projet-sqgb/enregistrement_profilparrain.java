<div id="step1" style="display: none;">
  <h2>Vérification des informations</h2>
  <input id="numeroCin" placeholder="Numéro CIN">
  <input id="numeroElecteur" placeholder="Numéro électeur">
  <input id="nom" placeholder="Nom">
  <input id="bureauVote" placeholder="Bureau de vote">
  <button onclick="verifierElecteur()">Vérifier</button>
</div>

<div id="step2" style="display: none;">
  <h2>Ajout des informations de contact</h2>
  <input id="telephone" placeholder="Téléphone">
  <input id="email" placeholder="Email">
  <button onclick="ajouterContact()">Suivant</button>
</div>

<div id="step3" style="display: none;">
  <h2>Vérification du code</h2>
  <input id="codeVerification" placeholder="Code reçu">
  <button onclick="verifierCode()">Valider</button>
</div>

<script>
  let etape = 1;
  afficherEtape();

  function afficherEtape() {
    document.getElementById("step1").style.display = etape === 1 ? "block" : "none";
    document.getElementById("step2").style.display = etape === 2 ? "block" : "none";
    document.getElementById("step3").style.display = etape === 3 ? "block" : "none";
  }

  function verifierElecteur() {
    // Ajoutez ici la logique de vérification
    etape = 2;
    afficherEtape();
  }

  function ajouterContact() {
    // Ajoutez ici la logique pour enregistrer le contact
    etape = 3;
    afficherEtape();
  }

  function verifierCode() {
    // Ajoutez ici la logique de validation du code
    alert("Vérification réussie !");
  }
</script>

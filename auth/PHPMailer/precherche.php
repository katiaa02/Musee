<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="musée, evasion, art, culture, loisir, France, divertissement, oeuvres, histoire">
  <meta name="robots" content="index,follow">
  <meta name="description" content="La plateforme dédiée aux amateurs de musées, offrant une expérience 100% unique pour explorer et découvrir les trésors artistiques et culturels à travers la France.">
  <link rel="icon"  type="img/ico" href="./favicon1.ico">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="design.css">
  <link rel="stylesheet" href="choix.css">
  <title>Recherche de musées</title>
</head>
<body>
  <?php include('./header.php') ?>
  
  <div class="main"> 
    <div class="background-container">
      <div class="background-image background-image1"></div>
      <div class="background-image background-image2"></div>
      <div class="background-image background-image3"></div>
    </div>

    <div id="searchContainer" class="container">
      <div class="titre">
        <h1 class="heading"> Découvrez les trésors culturels des musées français! </h1>
      </div>

      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-3">
          <form id="formcity" action="recherche.php" method="GET" class="input-group text-center">
            <div class="input-group">
              <input type="text" class="form-control form-control-lg" id="cityInput" name="ville" placeholder="Tapez la ville de votre choix" autocomplete="off">
              <div class="input-group-append">
                <button type="submit" class="btn btn-primary btn-sm rounded-pill" style="margin-left: 3px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="white-icon" color fill="white">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                  </svg>
                </button>
              </div>
            </div>
            <select id="citySelect" size ="5" style="display: none; width: 100%;  overflow-y: scroll;" class ="browser-default custom-select"></select>
          </form>
        </div>

        <div class="col-md-5">
          <form id="formmus" action="description.php" method="GET" class="input-group text-center">
            <div class="input-group">
              <input type="text" class="form-control form-control-lg" id="museumInput" name="nomoff" placeholder="Tapez le nom d'un musée" autocomplete="off">
              <div class="input-group-append">
                <button type="submit" class="btn btn-primary btn-sm rounded-pill" style="margin-left: 3px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="white-icon" color fill="white">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                  </svg>
                </button>
              </div>
            </div>
            <select id="museumSelect" size="5" style="display: none; width: 100%; overflow-y: scroll;"></select>
          </form>
        </div>
      </div>

      
    </div>

    <script>
      fetch('https://data.culture.gouv.fr/api/records/1.0/search/?dataset=musees-de-france-base-museofile&rows=1000')
        .then(response => response.json())
        .then(data => {
          const cities = new Set(); // Utilisation d'un ensemble pour éviter les doublons de villes

          data.records.forEach(record => {
            if (record.fields.ville_m) {
              cities.add(record.fields.ville_m);
            }
          });

          const cityInput = document.getElementById('cityInput');
          const citySelect = document.getElementById('citySelect');

          cityInput.addEventListener('input', () => {
            const searchValue = cityInput.value.toLowerCase();
            const matchingCities = [...cities].filter(city => city.toLowerCase().startsWith(searchValue));

            citySelect.innerHTML = '';
            matchingCities.slice(0, 5).forEach(city => {
              const option = document.createElement('option');
              option.value = city;
              option.textContent = city;
              citySelect.appendChild(option);
            });

            citySelect.style.display = matchingCities.length > 0 ? 'block' : 'none';
          });

          // Hide the select and fill the input with selected value on select change
          citySelect.addEventListener('change', (event) => {
            cityInput.value = event.target.value;
            citySelect.style.display = 'none';
          });

          // Show the select on focus of the input
          cityInput.addEventListener('focus', () => {
            citySelect.style.display = 'block';
          });
        })
        .catch(error => {
          console.log('Une erreur s\'est produite lors de la récupération des données :', error);
        });
    </script>

    <script>
      fetch('https://data.culture.gouv.fr/api/records/1.0/search/?dataset=musees-de-france-base-museofile&rows=1000')
        .then(response => response.json())
        .then(data => {
          const museums = new Set(); // Utilisation d'un ensemble pour éviter les doublons de noms de musées

          data.records.forEach(record => {
            if (record.fields.nomoff) {
              museums.add(record.fields.nomoff);
            }
          });

          const museumInput = document.getElementById('museumInput');
          const museumSelect = document.getElementById('museumSelect');

          museumInput.addEventListener('input', () => {
            const searchValue = museumInput.value.toLowerCase();
            const matchingMuseums = [...museums].filter(museum => museum.toLowerCase().includes(searchValue));

            museumSelect.innerHTML = '';
            matchingMuseums.slice(0, 5).forEach(museum => {
              const option = document.createElement('option');
              option.value = museum;
              option.textContent = museum;
              museumSelect.appendChild(option);
            });

            museumSelect.style.display = matchingMuseums.length > 0 ? 'block' : 'none';
          });

          museumSelect.addEventListener('change', (event) => {
            museumInput.value = event.target.value;
            museumSelect.style.display = 'none';
          });

          museumInput.addEventListener('focus', () => {
            museumSelect.style.display = 'block';
          });
        })
        .catch(error => {
          console.log('Une erreur s\'est produite lors de la récupération des données :', error);
        });

      document.addEventListener('click', (event) => {
            const target = event.target;
            if (target !== museumInput && target !== museumSelect && target !== cityInput && target !== citySelect) {
              museumSelect.style.display = 'none';
              citySelect.style.display = 'none';
              console.log('click');
            }
          });
    </script>

  </div>
  <footer style="background-color: #343a40;">
    <div class="container p-4">
      <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #d07214;">Bienvenue</h5>
          <p style="color: white;">
            Muséevasion est une plateforme dédiée aux amateurs de musées, offrant une expérience unique pour explorer et découvrir les trésors artistiques et culturels à travers le monde. Ce site captivant vous emmène dans un voyage virtuel, invitant les passionnés d'art, d'histoire et de culture à explorer une vaste collection de musées renommés, sans quitter le confort de chez eux
          </p>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #d07214;">links</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-1">
              <a href="index.php" style="color: white;">Accueil</a>
            </li>
            <li class="mb-1">
              <a href="precherche.php" style="color: white;">Musées</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="social-icons">
            <a href="#"><img src="../facebook.png" alt="Facebook"></a>
            <a href="#"><img src="../Instagram.png" alt="Instagram"></a>
            <a href="#"><img src="../tel.png" alt="telephone"> <span id="telephone">Numéro de téléphone : +123 456 789</span></a>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2023 muséevasion.alwaysdata.net
    </div>
  </footer>
</body>
</html>

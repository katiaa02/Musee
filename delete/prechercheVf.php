<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="icon"  type="img/ico" href="./favicon1.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="design.css">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- Matomo -->
    <script>
    var _paq = window._paq = window._paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="https://alwaysdata2.matomo.cloud/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src='//cdn.matomo.cloud/alwaysdata2.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);
    })();
    </script>
    <!-- End Matomo Code -->
</head>
<body>
<?php include('./header.php') ?>
    
    
<div id="searchContainer">
        <div id="selectville">
           
           
            <form action="recherche.php" method="GET">
                <label for="citySelect">Choisissez une ville :</label>
                <input type="text" id="cityInput" name="ville" placeholder="Tapez le nom d'une ville">
                <select id="citySelect" size="5" style="display: none;"></select> 
                <!-- La liste -->
                <!-- <button id="searchButton" type="submit">  <i class="fa fa-search"></i></button> -->
            </form>
            <div id="chercherparnom">
                <form id="formnom" action="description.php" method="GET">
                <label for="museumInput">Choisissez un musée :</label>
                <input type="text" id="museumInput" name="musee" placeholder="Tapez le nom d'un musée">
                <select id="museumSelect" size="5" style="display: none;"></select> <!-- La liste -->
                <!-- <button id="searchButtonnom" type="submit"><i class="fa fa-search"></i></button> -->
            </form>
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
</div>
       

 <!--         la recherche par nom              -->
        
         

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
</script>

        </div>
        
    </div>
                      <section class="category">
               <h1 class="heading"> Découvrez les trésors culturels des musées français. </h1>
             <div class="box-container">
               
                <div class="box">
                    <img src="idea.jpg" alt="">
                    <h3>musée de louvre</h3>
                    <p>Le Louvre à Paris est un musée mondialement célèbre, avec des œuvres majeures telles que la Joconde et la Vénus de Milo. Il incarne la richesse culturelle de la France et attire des visiteurs du monde entier.</p>
                    <a href="#" class="btn">Lire Plus</a>

                </div>

                <div class="box">
                    <img src="Orangerie.jpg" alt="">
                    <h3>Musée de l’Orangerie</h3>
                    <p>Le musée de l'Orangerie à Paris est célèbre pour ses chefs-d'œuvre impressionnistes, dont les Nymphéas de Monet. C'est une destination incontournable pour les amoureux de l'art du monde entier</p>
                    <a href="#" class="btn">Lire Plus</a>

                </div>

                <div class="box">
                    <img src="idea2.jpg" alt="">
                    <h3>Musée d'Orsay</h3>
                    <p>Le musée d'Orsay, à Paris, abrite une collection d'art impressionniste et post-impressionniste, incluant des œuvres de Monet, Degas, et Van Gogh. Incontournable pour les passionnés d'art du monde entier.</p>
                    <a href="#" class="btn">Lire Plus</a>

                </div>
             </div>


        </section>


        <script src="choix.js"></script>

</body>
</html>

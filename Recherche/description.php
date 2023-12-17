<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="icon"  type="img/ico" href="./favicon1.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../design.css">
    <style>
.col-md-4 {
    align-self: center;
}

body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    color: #3e2723; 
    line-height: 1.6;
  
    min-height: 100vh;
}

.container {  display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}
.description {
    font-size: 1rem;
    margin-bottom: 20px;
    color: #795548;
    margin: 6rem;
        }
h2 {
    font-size: 2rem;
    color: #bf360c; /* Rouge profond */
    margin-bottom: 10px;
}

p {
    font-size: 1.2rem;
    margin-bottom: 20px;
}

img {
    width: 300px;
    height: 200px;
    object-fit: cover;
    border-radius: 20px;
}

#map {
        height: 250px;
        width: 60%; 
        border: 2px solid #ddd; 
        border-radius: 10px;
        margin: 20px auto; 
        position: relative; 
    }

    

.leaflet-tile-pane {
    filter: grayscale(100%);
}


.leaflet-control {
    background-color: #fff; 
    border-radius: 5px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); 
    padding: 5px; 
    margin: 5px; 
    font-size: 14px; 
}
      
    </style>
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
<!-- _______________________recherche par ville__________________________________-->
<br>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (isset($_GET['nomoff'])) {
                $museum_name = $_GET['nomoff'];

                // Replace apostrophes with double apostrophes
                $museum_name = str_replace("'", "\'", $museum_name);

                $api_url = "https://data.culture.gouv.fr/api/explore/v2.1/catalog/datasets/musees-de-france-base-museofile/records?where=nomoff%3D%27" . urlencode($museum_name) . "%27&limit=20";

                $response = file_get_contents($api_url);
                $data = json_decode($response, true);

                if (isset($data['results'][0])) {
                    $record = $data['results'][0];
                    $museum_address = $record['adrl1_m'];
                    ?>
                        <h2><?= $record['nomoff'] ?></h2>
                        <h3> L'histoire du musée :</h3>
                        <?= $record['hist'] ?><br>

                        <h3> Les thèmes du musée :</h3>
                        <?php
                        if (isset($record['themes'])) {
                            $themes = explode(';', $record['themes']);
                            foreach ($themes as $theme) {
                                echo $theme . "<br>";
                            }
                        }
                        ?>
                        <h3> L'adresse du musée :</h3>
                        <?= $record['adrl1_m'] ?><br>
                        <h3> Contacts du musée :</h3>
                        <?= $record['tel_m'] ?><br>

                        <a href="http://<?= $record['url_m'] ?>" target="_blank"><?= $record['url_m'] ?></a><br>

                        <script>var adresse = '<?= $record['adrl1_m'] ?>';</script>
        </div>
        <div class="col-md-4">
                    <?php
                        require_once 'fonctions.php';
                        $imagelink = getImage($record['nomoff']);
                        echo "<img src='" . $imagelink . "' alt=\"image\" >";
                }
            }
            
            ?>
        </div>
        </div>
    </div>
    <div id="map"></div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        <?php if (isset($record['latitude']) && isset($record['longitude'])) { ?>
            var lat = <?php echo $record['latitude']; ?>;
            var lon = <?php echo $record['longitude']; ?>;
            L.marker([lat, lon]).addTo(map);
            map.setView([lat, lon], 15);
        <?php } else { ?>
            console.log("salut", lat, lon);
            alert("L'adresse n'a pas été trouvée sur la carte");
        <?php } ?>
    });
</script>

</body>
</html>

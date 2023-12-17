<?php 
session_start();
$servername = "mysql-museevasion.alwaysdata.net";
$username = "332768";
$password = "Projet2023m*";
$dbname = "museevasion_db"; ?>
<?php
// Fetch data from API
$ville_rech = $_GET['ville'];
$ville_rech = str_replace("'", "\'", $ville_rech);

if (strpos($ville_rech, '(') !== false && strpos($ville_rech, ')') !== false) {
    $ville_rech = urlencode($ville_rech);
}

$url = 'https://data.culture.gouv.fr/api/explore/v2.1/catalog/datasets/musees-de-france-base-museofile/records?select=nomoff%2C%20hist%2C%20adrl1_m&where=ville_m%20%3D%20%27'. $ville_rech .'%27&limit=100';
$data = file_get_contents($url);

// Check if data was fetched successfully
if ($data === false) {
    die('Erreur lors de la récupération des données de l\'API.');
}

// Convert JSON data to PHP array
$results = json_decode($data, true);

// Check if JSON data was converted successfully
if ($results === null) {
    die('Erreur lors de la conversion des données JSON.');
}

// Define function to get image link from Wikipedia API
function getImageLinkByDescription($description) {
    $wikiEndpoint = 'https://en.wikipedia.org/w/api.php';

    $searchParams = array(
        'action' => 'query',
        'format' => 'json',
        'prop' => 'pageimages',
        'piprop' => 'thumbnail',
        'pithumbsize' => '300',
        'pilimit' => '1',
        'generator' => 'search',
        'gsrsearch' => $description,
        'gsrlimit' => '1',
    );

    $searchUrl = $wikiEndpoint . '?' . http_build_query($searchParams);

    $searchResponse = file_get_contents($searchUrl);

    $searchData = json_decode($searchResponse, true);

    if (!empty($searchData['query']['pages'])) {
        $pages = $searchData['query']['pages'];
        foreach ($pages as $page) {
            if (isset($page['original'])) {
                $imageLink = $page['original']['source'];
                return $imageLink;
            }
        }
    }

    return null;
}



function getImage($nomoff) {
    $servername = "mysql-museevasion.alwaysdata.net";
    $username = "332768";
    $password = "Projet2023m*";
    $dbname = "museevasion_db";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT url_img FROM images WHERE nom_mus = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nomoff);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imageLink = $row["url_img"];
        if ($imageLink === null) {
            $imageLink = "/photom/barre-oblique.png";
        }
    }
    else {
        $imageLink = getImageLinkByDescription($nomoff);
        if ($imageLink === null) {
            $imageLink = "/photom/barre-oblique.png";
        }
    }

    $conn->close();

    return $imageLink;
}





// Define variables for pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$resultsPerPage = 12;
$totalResults = count($results['results']);
$totalPages = ceil($totalResults / $resultsPerPage);
$offset = ($page - 1) * $resultsPerPage;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"  type="img/ico" href="./favicon1.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../design.css">
    
    <title>Document</title>
    <style>
            .image,.image2 {
            width: 90%;
            height: 60%;
            object-fit: cover;
        }

        #page_bar {
            position: absolute;
            left: 43%;
            margin-top: 20px;
            max-width: 11%;
        }
        .card-body h5 a {
            color: #4e342e; 
   
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Ajoute une ombre pour donner un effet de "soulèvement" */
            transform: scale(1.05); /* Légèrement agrandir la carte */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Ajoute un effet de transition doux */
        }
        .card-body a:hover {
            text-decoration: underline; /* Souligne le texte au survol */
            color: #0056b3; /* Change la couleur du lien, ajustez selon votre palette de couleurs */
         }


        .card-body h5 a:hover {
            color: #d07214; 
        }

        .card img::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 700%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            z-index: 2;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .divimage {
            height: 120px; 
            object-fit: cover; 
        }
        .divimage img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .card img:hover::after {
            opacity: 1;
        }


        .card {
            background-color: #f5f5f5;
            border-radius: 50px / 20px; 
            transition: box-shadow 0.3s ease;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            width: 100%;
            height: 90%;
        }
        .card:hover h5 a {
            color: #007bff; /* Couleur au survol */
            font-weight: bold; /* Rendre le texte plus épais */
            text-decoration: underline; /* Ajouter un soulignement */
        }
        .card-body h5 a {
             transition: transform 0.3s ease, color 0.3s ease;
        }

        .card:hover h5 a {
            transform: scale(1.05); /* Légère augmentation de la taille */
            color: #d07214; /* Change la couleur */
        }


        .panel-title a {
            color: #333;
        }

        .card button {
            margin-top: 10px;
        }

        body {
            padding: 20px;
        }
        #mainContainer {
            margin-left: 300px; /* Marge à gauche pour laisser de l'espace au conteneur de recherche */
        }

        .panel-title a:hover {
            color: #428bca;
        }
        .panel-collapse {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }
        h5 a {
            text-decoration: none; /* Retire le soulignement du lien dans le titre h5 */
        }
        h5 a:hover {
            text-decoration: none; /* Retire le soulignement du lien dans le titre h5 */
        }
        h5 {
            font-weight: bold;
            text-decoration: none; 
        }

        #searchchange {
                flex-direction: column;
                height: 40%;
                width: 110%;
                background-color: #f2f2f2;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                position: inherit;
                margin-top: 10%;
                margin-left: -5%;
            }

            #searchchange form {
                margin-bottom: 10px;
            }

            #searchchange label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            #searchchange input[type="text"],
            #searchchange {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            #searchchange {
                position: relative;
            }

            #selectville select {
                width: 80%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                background-color: #fff;
                z-index: 2;
                position: absolute;
                top: calc(26% + 5px); /* Position just below the text input with ID "cityInput" */
                left: 7%; /* Align with the left edge of the input */
            }
            
            #chercherparnom select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                background-color: #fff;
                z-index: 2;
                position: absolute;
                top: calc(51% + 5px); /* Position just below the text input with ID "cityInput" */
            }

            #searchchange button {
                padding: 8px 16px;
                background-color: #428bca;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            #searchchange button:hover {
                background-color: #3276b1;
            }
            
        </style>
        </head>
        <body>
        <?php include('./header.php'); ?>
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
                    if (target !== museumInput && target !== cityInput) {
                        museumSelect.style.display = 'none';
                        citySelect.style.display = 'none';
                        console.log('click');
                    } else if (target === museumInput) {
                        citySelect.style.display = 'none';
                    } else if (target === cityInput) {
                        museumSelect.style.display = 'none';
                    } else {
                        museumSelect.style.display = 'none';
                        citySelect.style.display = 'none';
                    }
                });
        </script>
        <br>
        <br>
            <div class="row">
                <div class="col-md-2">
                    <div class="container">
                        <div id="searchchange">
                            <div id="selectville">
                                <form action="recherche.php" method="GET">
                                    <div class="form-group">
                                        <label for="citySelect">Choisissez une ville :</label>
                                        <input type="text" id="cityInput" name="ville" class="form-control" placeholder="Tapez le nom d'une ville" autocomplete="off">
                                        <select id="citySelect" size="5" style="display: none;" class="form-control"></select> <!-- La liste -->
                                    </div>
                                    <button id="searchButton" type="submit" class="btn btn-primary">Rechercher</button>
                                </form>
                            </div>

                            <div id="chercherparnom">
                                <form id="formnom" action="description.php" method="GET">
                                    <div class="form-group">
                                        <label for="museumInput">Choisissez un musée :</label>
                                        <input type="text" id="museumInput" name="nomoff" class="form-control" placeholder="Tapez le nom d'un musée" autocomplete="off">
                                        <select id="museumSelect" size="5" style="display: none;" class="form-control"></select> <!-- La liste -->
                                    </div>
                                    <button id="searchButtonnom" type="submit" class="btn btn-primary">Rechercher</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if (isset($_GET['ville'])) {
                                $ville = htmlspecialchars($_GET['ville']);
                                echo '<h2>Les musées de la ville de ' . $ville . '</h2>';
                            }
                            ?>
                            <div class="row">
                                <?php
                                // Loop through results and output HTML code for each museum
                                for ($i = $offset; $i < $offset + $resultsPerPage && $i < $totalResults; $i++) {
                                    $record = $results['results'][$i];
                                ?>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><a href="description.php?nomoff=<?php echo urlencode($record['nomoff']); ?>"><?php echo $record['nomoff']; ?></a></h5>
                                                <p class="card-text"><strong>Adresse:</strong> <?php echo $record['adrl1_m']; ?></p>
                                                <?php
                                                if (isset($_SESSION['id_utilisateur'])) {
                                                    // L'utilisateur est connecté
                                                    $servername = "mysql-museevasion.alwaysdata.net";
                                                    $username = "332768";
                                                    $password = "Projet2023m*";
                                                    $dbname = "museevasion_db";

                                                    // Création de la connexion
                                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                                    // Vérification de la connexion
                                                    if ($conn->connect_error) {
                                                        die("La connexion a échoué : " . $conn->connect_error);
                                                    }

                                                    $utilisateur_id = $_SESSION['id_utilisateur'];
                                                    $musee_nom = urldecode($record['nomoff']);

                                                    // Vérifier si le musée est déjà dans les favoris de l'utilisateur
                                                    $sql_check_favorite = "SELECT * FROM favoris WHERE id_utilisateur = ? AND nom_mus = ?";
                                                    $stmt_check = $conn->prepare($sql_check_favorite);
                                                    $stmt_check->bind_param("is", $utilisateur_id, $musee_nom);
                                                    $stmt_check->execute();
                                                }
                                                ?>
                                                <?php
                                                if (isset($_SESSION['id_utilisateur'])) {
                                                    // L'utilisateur est connecté
                                                    $servername = "mysql-museevasion.alwaysdata.net";
                                                    $username = "332768";
                                                    $password = "Projet2023m*";
                                                    $dbname = "museevasion_db";

                                                    // Création de la connexion
                                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                                    // Vérification de la connexion
                                                    if ($conn->connect_error) {
                                                        die("La connexion a échoué : " . $conn->connect_error);
                                                    }

                                                    $utilisateur_id = $_SESSION['id_utilisateur'];
                                                    $musee_nom = urldecode($record['nomoff']);

                                                    // Vérifier si le musée est déjà dans les favoris de l'utilisateur
                                                    $sql_check_favorite = "SELECT * FROM favoris WHERE id_utilisateur = ? AND nom_mus = ?";
                                                    $stmt_check = $conn->prepare($sql_check_favorite);
                                                    $stmt_check->bind_param("is", $utilisateur_id, $musee_nom);
                                                    $stmt_check->execute();
                                                    $result = $stmt_check->get_result();

                                                    if ($result->num_rows > 0) {
                                                        // Le musée est déjà dans les favoris, désactiver le bouton et modifier le texte
                                                        echo '<button type="button" class="btn btn-primary" disabled>Déjà dans les favoris</button>';
                                                    } else {
                                                        // Le musée n'est pas dans les favoris, afficher le bouton pour ajouter
                                                        echo '<form method="POST" action="../favoris/addfav.php">';
                                                        echo '<input type="hidden" name="musee_nom" value="' . urlencode($record['nomoff']) . '">';
                                                        echo '<button type="submit" name="favoris" value="toggle" class="btn btn-primary">Ajouter aux favoris</button>';
                                                        echo '</form>';
                                                    }

                                                    // Fermeture de la connexion à la base de données
                                                    $conn->close();
                                                } else {
                                                    // L'utilisateur n'est pas connecté, afficher un lien ou un bouton redirigeant vers la page de connexion
                                                    $error_message = "Veuillez vous identifier pour ajouter un musée aux favoris";
                                                    $error_message_encoded = urlencode($error_message);
                                                    echo '<form method="POST" action="../auth/connexion.php?error_message=' . $error_message_encoded . '">';
                                                    echo '<input type="hidden" name="musee_nom" value="' . urlencode($record['nomoff']) . '">';
                                                    echo '<button type="submit" name="favoris" value="toggle" class="btn btn-primary">Ajouter aux favoris</button>';
                                                    echo '</form>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <nav aria-label="Page navigation example" id="page_bar">
                                <ul class="pagination justify-content-center">
                                    <?php
                                    // Output HTML code for pagination
                                    for ($i = 1; $i <= $totalPages; $i++) {
                                        $active = $i == $page ? ' active' : '';
                                        echo '<li class="page-item' . $active . '"><a class="page-link" href="?page=' . $i . '&ville=' . urlencode($_GET['ville']) . '">' . $i . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        </body>
        </html>

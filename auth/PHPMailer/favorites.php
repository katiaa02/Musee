<?php 
session_start();
include('./header.php');

$servername = "mysql-museevasion.alwaysdata.net";
$username = "332768";
$password = "Projet2023m*";
$dbname = "museevasion_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: index.php");
    exit(); // Gérer le cas où l'utilisateur n'est pas connecté
}

$utilisateur_id = $_SESSION['id_utilisateur'];

// Récupérer les musées favoris de l'utilisateur depuis la base de données
$sql_get_favoris = "SELECT * FROM favoris WHERE id_utilisateur = ?";
$stmt = $conn->prepare($sql_get_favoris);
$stmt->bind_param("i", $utilisateur_id);
$stmt->execute();
$result_get_favoris = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="design.css">
    <style>
     .titlefav{
     color:#d07214;
        
        }
        </style>
    <title>Musées favoris</title>
</head>
<body>

<div class="container">
<h1 style="margin-top: 6rem;" class="titlefav">Musées favoris</h1>



    <div class="row">
        <?php
        if ($result_get_favoris->num_rows > 0) {
            while ($row = $result_get_favoris->fetch_assoc()) {
                $museumName = $row['nom_mus']; // Nom du musée favori
                
                // Construire l'URL de l'API avec le nom du musée
                $apiUrl = 'https://data.culture.gouv.fr/api/records/1.0/search/?dataset=musees-de-france-base-museofile&q=' . urlencode($museumName) . '&rows=1';
                
                // Faire une requête à l'API
                $response = file_get_contents($apiUrl);
                
                // Vérifier si la réponse est valide
                if ($response === false) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<p class="card-text">Erreur lors de la requête à l\'API pour ' . $museumName . '.</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    $data = json_decode($response, true); // Convertir la réponse en tableau associatif
                
                    // Vérifier si des résultats ont été retournés
                    if (isset($data['records']) && count($data['records']) > 0) {
                        // Récupérer les détails du premier résultat
                        $museumDetails = $data['records'][0]['fields'];
                
                        // Afficher les détails du musée
                        echo '<div class="col-md-4">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $museumDetails['nomoff'] . '</h5>'; // Afficher le nom du musée
                        echo '<p class="card-text"><strong>Adresse:</strong> ' . $museumDetails['adrl1_m']  . '</p>'; 
                        
                        // Bouton pour retirer le musée des favoris
                        echo '<form method="POST" action="remove_from_favorites.php">';
                        echo '<input type="hidden" name="musee_nom" value="' . urlencode($museumName) . '">';
                        echo '<button type="submit" class="btn btn-danger btn-sm" name="favoris" value="toggle">Retirer des favoris</button>';
                        echo '</form>';
                        
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="col-md-4">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<p class="card-text">Aucune information trouvée pour ' . $museumName . '.</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
        } else {
            echo '<p>Aucun musée favori trouvé.</p>';
        }
        ?>
    </div>
</div>

</body>
</html>

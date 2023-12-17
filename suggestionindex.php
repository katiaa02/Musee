<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mail = $_POST["mail"];
    $suggestion = $_POST["suggestion"];

    $servername = "mysql-museevasion.alwaysdata.net";
   $username = "332768";
$password = "Projet2023m*";
$dbname = "museevasion_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO suggestion  (Nom_suggestion, Prenom_suggestion, mail_suggestion, description_sugg) VALUES ('$nom', '$prenom', '$mail', '$suggestion')";

    // Exécuter la requête SQL
    if ($conn->query($sql) === TRUE) {
        echo "Données enregistrées avec succès dans la base de données.";
    } else {
        echo "Erreur lors de l'enregistrement des données : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>

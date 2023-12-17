<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $servername = "mysql-museevasion.alwaysdata.net";
    $username = "332768";
    $password = "Projet2023m*";
    $dbname = "museevasion_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $id_utilisateur = $_GET['id_utilisateur'];
    $token = $_GET['token'];
    $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = '$id_utilisateur' AND validation_token = '$token'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sql = "UPDATE utilisateur SET verified = true WHERE id_utilisateur = '$id_utilisateur'";
        $result = $conn->query($sql);
        header("Location: connexion.php?validated=1");

    } else {
        echo "Erreur";
    }



}

<?php
session_start();

$servername = "mysql-museevasion.alwaysdata.net";
$username = "332768";
$password = "Projet2023m*";
$dbname = "museevasion_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['musee_nom'])) {
    $museumName = urldecode($_POST['musee_nom']);

    if (!isset($_SESSION['id_utilisateur'])) {
        header("Location: index.php");
        exit(); // Gérer le cas où l'utilisateur n'est pas connecté
    }

    $utilisateur_id = $_SESSION['id_utilisateur'];

    // Vérifier d'abord si le musée est dans les favoris avant de le supprimer ou de l'ajouter
    $sql_check_favori = "SELECT * FROM favoris WHERE id_utilisateur = ? AND nom_mus = ?";
    $stmt_check = $conn->prepare($sql_check_favori);
    $stmt_check->bind_param("is", $utilisateur_id, $museumName);
    $stmt_check->execute();
    $result_check_favori = $stmt_check->get_result();

    if ($result_check_favori->num_rows > 0) {
        // Si le musée est dans les favoris, le supprimer
        $sql_remove_favori = "DELETE FROM favoris WHERE id_utilisateur = ? AND nom_mus = ?";
        $stmt_remove = $conn->prepare($sql_remove_favori);
        $stmt_remove->bind_param("is", $utilisateur_id, $museumName);
        $stmt_remove->execute();
    } else {
        // Si le musée n'est pas dans les favoris, l'ajouter
        $sql_add_favori = "INSERT INTO favoris (id_utilisateur, nom_mus) VALUES (?, ?)";
        $stmt_add = $conn->prepare($sql_add_favori);
        $stmt_add->bind_param("is", $utilisateur_id, $museumName);
        $stmt_add->execute();
    }
}

// Redirection vers la page précédente
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>

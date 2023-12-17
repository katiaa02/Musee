<?php
session_start();
// Vérification si la requête est bien de type POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérification si le bouton "favoris" a été soumis
    if (isset($_POST['favoris']) && $_POST['favoris'] === 'toggle') {
        // Connexion à la base de données (vous devrez remplacer ces valeurs par vos propres informations de connexion)
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
        if (!isset($_SESSION['id_utilisateur'])) {
            header("Location: ../auth/connexion.php?error_message=Veilliez+vous+identifier+pour+ajouter+un+musée+aux+favoris");
            exit(); // Gérer le cas où l'utilisateur n'est pas connecté
        }
        // Récupération du nom du musée depuis les données postées
        $musee_nom = urldecode($_POST['musee_nom']);
        $utilisateur_id = $_SESSION['id_utilisateur'];

        echo "ID Utilisateur: " . $utilisateur_id . "<br>";
        echo "Nom Musée: " . $musee_nom . "<br>";

        // Requête pour insérer ou mettre à jour le musée dans la table des favoris
        $sql = "INSERT INTO favoris (id_utilisateur, nom_mus) VALUES (?, ?)";
        $stmt_add = $conn->prepare($sql);

        // Liaison des paramètres et exécution de la requête préparée
        $stmt_add->bind_param("is", $utilisateur_id, $musee_nom);




        if ($stmt_add->execute()) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Erreur lors de l'ajout du musée aux favoris : " . $stmt_add->error;
        }

        // Fermeture de la connexion à la base de données
        $conn->close();
    } else {
        echo "Paramètres invalides pour l'ajout aux favoris.";
    }
} else {
    echo "Méthode de requête invalide. Veuillez soumettre les données via le formulaire.";
}
?>

<?php
    session_start();

    $servername = "mysql-museevasion.alwaysdata.net";
    $username = "332768";
    $password = "Projet2023m*";
    $dbname = "museevasion_db";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require 'verif_valid.php';
        if (checkPassword($_POST['newpass']) == "valid" && checkPasswordRepeat($_POST['newpass'], $_POST['confirmpass']) == "valid") {
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "UPDATE utilisateur SET mdp = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", password_hash($_POST['newpass'], PASSWORD_DEFAULT), $_SESSION['email']);
            $stmt->execute();
            $conn->close();
            header('Location: profil.php?status=0');
            exit();
        } elseif (checkPasswordRepeat($_POST['newpass'], $_POST['confirmpass']) !== "valid") {
            header('Location: profil.php?&status=1');
            exit();
        } else {
            header('Location: profil.php?&status=2');
            exit();
        }
    }
?>

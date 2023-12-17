<?php
session_start();
require 'PHPMailer/src/PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\SMTP;
require 'PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\Exception;

require 'verif_valid.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password_repeat'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    function generateRandomBytes($length = 32) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
    
    // Utilisation
    $token = generateRandomBytes(15);
    
    
    // Verify data validity
    $username_check = checkUsername($username, $conn);
    $email_check = checkEmail($email, $conn);
    $password_check = checkPassword($password);
    $password_repeat_check = checkPasswordRepeat($password, $password2);

    if ($username_check !== "" || $email_check !== "valid" || $password_check !== "valid" || $password_repeat_check !== "valid" || !checkRecaptcha($_POST['g-recaptcha-response'], "6LemBREpAAAAAJ3ADPXh7BncUB2fh8FolZSC168a") ) {
        header("Location: inscription_page.php?error_message=donnee+invalide,veuillez+reessayer");
        exit();
    }

    // Insert user data
    $sql = "INSERT INTO utilisateur (nom, prenom, username, email, mdp, validation_token) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nom, $prenom, $username, $email, $hashed_password, $token);

    if ($stmt->execute()) {
       // echo "User created successfully";
    } else {
        //echo "Error creating user: " . $conn->error;
    }

    $stmt->close();

    // Select user data
    $sql = "SELECT id_utilisateur, validation_token FROM utilisateur WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id_utilisateur = $row['id_utilisateur'];
    $Validationtoken = $row['validation_token'];

    $confirmation_link = "http://museevasion.alwaysdata.net/validation.php?id_utilisateur=" . $id_utilisateur . "&token=" . $Validationtoken;

    $stmt->close();

    // Create a PHPMailer instance
    $mail = new PHPMailer;

    // Configure SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp-museevasion.alwaysdata.net';
    $mail->SMTPAuth = true;
    $mail->Username = 'museevasion@alwaysdata.net';
    $mail->Password = 'Projet2023m*';
    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Set the sender and recipient email addresses
    $mail->setFrom('museevasion@alwaysdata.net', 'Museevasion');
    $mail->addAddress($email, $email);

    // Set the subject and body of the message
    $mail->Subject = "Confirmation de votre inscription sur Museevasion";
    $mail->Body    = "Bonjour,\n\nVeuillez cliquer sur le lien suivant pour confirmer votre inscription sur Museevasion : " . $confirmation_link . "\n\nCordialement,\n\nL'équipe Museevasion";

    // Send the message
    if(!$mail->send()) {
        echo 'Error: ' . $mail->ErrorInfo;
    } else {
       // Après avoir envoyé le courriel de confirmation et fait tout ce que tu as besoin de faire,
// tu peux définir un message de succès dans la session
$_SESSION['success_message'] = "Veuillez confirmer votre inscription en cliquant sur le lien envoyé par e-mail!.$email";
header("Location: inscription_page.php");

exit();
 }

    $conn->close();
}
?>

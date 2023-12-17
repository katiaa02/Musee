<?php
require 'PHPMailer/src/PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\SMTP;
require 'PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\Exception;

require 'verif_valid.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'adresse e-mail saisie par l'utilisateur
    $email = $_POST['typeEmail'];


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


    $sql = "SELECT * FROM utilisateur WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header('Location: reset_password.php?status=error');
        exit;
    } 

    $validation_token = bin2hex(random_bytes(5));
    $sql = "UPDATE utilisateur SET validation_token = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $validation_token, $email);
    $stmt->execute();
    $conn->close();

    // Créer une instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Create a PHPMailer instance
        $mail = new PHPMailer;

        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp-museevasion.alwaysdata.net';
        $mail->SMTPAuth = true;
        $mail->CharSet = 'UTF-8';
        $mail->Username = 'museevasion@alwaysdata.net';
        $mail->Password = 'Projet2023m*';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set the sender and recipient email addresses
        $mail->setFrom('museevasion@alwaysdata.net', 'Museevasion');
        $mail->addAddress($email, $email);

        $mail->Subject = 'Password Reset';
        $mail->Body = 'Bonsoir, vous avez récément effectuer une demande de réunitialisation de votre mot de passe, cliquez sur ce lien pour le changer
        http://museevasion.alwaysdata.net/reset_password_form.php?email=' . $email . '&token=' . $validation_token;

        // Envoyer l'e-mail
        $emailSent = $mail->send();

        if ($emailSent) {
            // Rediriger l'utilisateur vers une page de confirmation
            header('Location: reset_password.php?status=success');
            exit;
        } else {
           header('Location: reset_password.php?status=error');
            exit;
        }
    } catch (Exception $e) {
        header('Location: reset_password.php?status=error');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="icon"  type="img/ico" href="./favicon1.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../design.css">
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
<?php include('header.php'); ?>

<div class="d-flex justify-content-center align-items-center" style="height: 100vh; margin-top: -5px;">
    <div class="card text-center" style="width: 300px;">
        <div class="card-header h5 text-white bg-primary">Password Reset</div>
        <div class="card-body px-4">
            <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                <div class="alert alert-success" role="alert">
                    Email envoyé avec sucées ! vérifiez votre boite mail.
                </div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>
            <p class="card-text py-2">
                Enter your email address and we'll send you an email with instructions to reset your password.
            </p>
            <form method="POST">
                <div class="form-outline">
                    <label class="form-label" for="typeEmail">Email:</label>
                    <input type="email" id="typeEmail" name="typeEmail" class="form-control my-3">
                </div>

                
                <?php 
                if (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
                    <div class="alert alert-danger" role="alert">
                        Email non trouvé.
                    </div> <?php endif; ?>

                <button type="submit" class="btn btn-primary w-100">Réinitialiser</button>
            </form>
            <div class="d-flex justify-content-between mt-4">
                <a class="" href="connexion.php">Connexion</a>
                <a class="" href="inscription_page.php">Inscription</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

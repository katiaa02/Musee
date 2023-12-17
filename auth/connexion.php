<?php
session_start();
require 'verif_valid.php';

// Rediriger vers index.php si l'utilisateur est déjà connecté
if (isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier les informations de connexion
    $user = verif_login($email, $password);
    if ($user !== null) {
        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['email'] = $user['email'];
        $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['username'] = $user['username'];

        // Rediriger vers index.php après une connexion réussie
        header("Location: ../index.php");
        exit();
    } else {
        // Rediriger vers connexion.php avec un message d'erreur
        header("Location: connexion.php?error_message=identifiants+incorrects");
        exit();
    }
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="icon"  type="img/ico" href="./favicon1.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../design.css">
</head>

<body>
    <?php include('./header.php'); ?>
    <div class="h-80 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-80" style="margin-top: 4vh;">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <a class="navbar-brand" href="../index.php"> <span>MUsée</span>VASION</a>
                                    </div>

                                    <form action="connexion.php" method="POST">
                                        <p>Veuillez vous connecter à votre compte!</p>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Adresse email :</label>
                                            <input type="email" id="email" name="email" class="form-control">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Mot de passe :</label>
                                            <input type="password" id="password" name="password" class="form-control">
                                        </div>

                                        <?php
                                        if (isset($_GET['validated']) && $_GET['validated'] === '1') {
                                            echo "<p style='color:green'>Merci d'avoir validé votre compte et bienvenue! Identifiez-vous </p>";
                                        } elseif (isset($_GET['status']) && $_GET['status'] === 'reset') {
                                            echo "<p style='color:green'>Votre mot de passe a été réinitialisé, veuillez vous connecter</p>";
                                        }
                                        ?>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                type="submit">Se connecter</button>

                                            <?php if (isset($_GET['error_message'])) {
                                                echo "<p style='color:red'>". $_GET['error_message'] ."</p>";
                                            } ?>

                                            <a class="text-muted" href="reset_password.php">Mot de passe oublié ?</a>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Vous n'avez pas de compte?</p>
                
                                            <a href="inscription_page.php" class="btn btn-outline-danger">Créer un compte</a>
                                        </div>
                                      
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                               
                                <img src="./Exposi.jpg" alt="Votre Image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <footer style="background-color: #343a40;">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4">
                    <h5 class="mb-3" style="letter-spacing: 2px; color: #d07214;">Bienvenue</h5>
                    <p style="color: white;">
                        Muséevasion est une plateforme dédiée aux amateurs de musées, offrant une expérience unique pour explorer et découvrir les trésors artistiques et culturels à travers le monde. Ce site captivant vous emmène dans un voyage virtuel, invitant les passionnés d'art, d'histoire et de culture à explorer une vaste collection de musées renommés, sans quitter le confort de chez eux
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3" style="letter-spacing: 2px; color: #d07214;">links</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1">
                            <a href="index.php" style="color: white;">Accueil</a>
                        </li>
                        <li class="mb-1">
                            <a href="precherche.php" style="color: white;">Musées</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="social-icons">
                        <a href="#"><img src="../facebook.png" alt="Facebook"></a>
                        <a href="#"><img src="../Instagram.png" alt="Instagram"></a>
                        <a href="#"><img src="../tel.png" alt="telephone"> <span id="telephone">Numéro de téléphone : +123 456 789</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 muséevasion.alwaysdata.net
        </div>
    </footer>    

    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="icon" type="img/ico" href="./favicon1.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <?php include('./header.php'); ?>
<br><br>
    <section class="vh-100" style="background-color: #f4f5f7;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white"
                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="./photom/user.png" alt="Avatar" class="img-fluid my-5" style="width: 80px;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Informations</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <p class="text-muted"><?php echo $_SESSION['email']; ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Non d'utilisateur</h6>
                                            <p class="text-muted"><?php echo $_SESSION['username']; ?></p>
                                        </div>
                                    </div>
                                    <h6>Information personnelles</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Nom</h6>
                                            <p class="text-muted"><?php echo $_SESSION['nom']; ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Prénom</h6>
                                            <p class="text-muted"><?php echo $_SESSION['prenom']; ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                                        <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                                        <a href="#!"><i class="fab fa-instagram fa-lg"></i></a>
                                    </div>
                                    <div class="form-group">
                                    <form action="password_change.php" method="post">
                                        <p role="alert" id="feedback_msg">
                                            <?php if (isset($_GET['status']) && $_GET['status'] == 0): ?>
                                                <div class="alert alert-success" role="alert">
                                                    Mot de passe changé avec succès!
                                                </div>
                                            <?php elseif (isset($_GET['status']) && $_GET['status'] == 1): ?>
                                                <div class="alert alert-danger" role="alert">
                                                    Les deux mots de passe ne correspondent pas!
                                                </div>
                                            <?php elseif (isset($_GET['status']) && $_GET['status'] == 2): ?>
                                                <div class="alert alert-danger" role="alert">
                                                    mot de passe trop simple !
                                                </div>
                                            <?php endif; ?>
                                        </p>
                                        <div class="form-group">
                                            <label for="newpass">Nouveau mot de passe</label>
                                            <input type="password" class="form-control form-control-sm" name="newpass">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmpass">Confirmer</label>
                                            <input type="password" class="form-control form-control-sm" name="confirmpass">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block submit-btn">Confirm</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
</body>
</html>
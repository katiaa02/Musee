<!DOCTYPE html>
<html lang="fr">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MuséEvasion, le meilleur site de référence des musées en France</title>
        <link rel="icon"  type="img/ico" href="./favicon1.ico">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="design.css">
        <meta name="keywords" content="musée, evasion, art, culture, loisir, France, divertissement, oeuvres, histoire">
        <meta name="description" content="La plateforme dédiée aux amateurs de musées, offrant une expérience 100% unique pour explorer et découvrir les trésors artistiques et culturels à travers la France.">


</head>
<body>
<?php include('./header.php'); ?>
        <section id="home">
                <h1 style ="color:white;">Explorez</h1>
                <h4>&nbsp;Découvrez l'art, la culture et l'histoire à l'infini.</h4>
                <p>&nbsp;Plongez dans l'univers de la connaissance et de l'inspiration sur notre site, où chaque clic ouvre une porte vers la découverte.</p>
                <a href="recherche/precherche.php" class="btn btn-primary exp">Explorez Maintenant</a>
        </section>
        <?php
                if (!isset($_COOKIE['accepted'])) {
                        echo '
                        <div class="cookie-consent" style="position: fixed; bottom: 0; left: 0; right: 0; background-color: rgba(96, 96, 96, 0.9); color: white; padding: 10px; text-align: center;">
                            <p>Ce site utilise des cookies pour son bon fonctionnement, veuillez les accepter s\'il vous plaît.</p>
                            <button id="accept-cookies" class="btn btn-primary">Accepter</button>
                            <button id="refuse-cookies" class="btn btn-danger">Refuser</button>
                        </div>
                        ';
                }
        ?>
        <script>
            document.getElementById("accept-cookies").addEventListener("click", function() {
                        document.cookie = "accepted=1";
                        document.getElementsByClassName("cookie-consent")[0].style.display = "none";
                });

            document.getElementById("refuse-cookies").addEventListener("click", function() {
                        document.cookie = "accepted=0";
                        document.getElementsByClassName("cookie-consent")[0].style.display = "none";
                });
        </script>
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
                            <a href="recherche\precherche.php" style="color: white;">Musées</a>
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
        <!-- Scripts Bootstrap (jQuery et Popper.js) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
                document.getElementById('email').addEventListener('change', function() {
                        var email = this.value;
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                        var response = xhr.responseText;
                                        console.log(response);
                                        // Modifier le code pour correspondre aux valeurs retournées par checkEmail
                                        if (response === 'exists') {
                                                document.getElementById('error_mail').innerText = "Le mail est déjà relié à un autre compte.";
                                                document.getElementById('email').nextElementSibling.style.visibility = 'hidden';
                                        } else if (response === 'valid') {
                                                document.getElementById('error_mail').innerText = "";
                                                document.getElementById('email').nextElementSibling.style.visibility = 'visible';
                                        } else {
                                                document.getElementById('error_mail').innerText = "Format email non valide !";
                                                document.getElementById('email').nextElementSibling.style.visibility = 'hidden';
                                        }
                                }
                        };
                        xhr.open('GET', './verif_valid.php?email=' + email, true);
                        xhr.send();
                });
        </script>
        <script>
            // Hide the cookie consent on mobile devices
            if (window.innerWidth <= 768) {
                var cookieConsent = document.querySelector('.cookie-consent');
                if (cookieConsent) {
                    cookieConsent.style.display = 'none';
                }
            }
        </script>
</body>
</html>

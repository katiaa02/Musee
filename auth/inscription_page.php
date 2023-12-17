<?php
session_start();
if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}  ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="icon"  type="img/ico" href="./favicon1.ico">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
<?php include ('header.php') ?>
<div class="container">

    <div class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-70" style="margin-top: 60vh;">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Créez un compte</h2>

                                <form id="form" action="confirmation_mail.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="nom">Nom:</label>
                                                <input name="nom" type="text" id="nom" class="form-control form-control-lg" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="prenom">Prénom:</label>
                                                <input name="prenom" type="text" id="prenom" class="form-control form-control-lg" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="username">Nom d'utilisateur:</label>
                                        <div class="d-flex align-items-center">
                                            <input name="username" type="text" id="username" class="form-control form-control-lg" required>
                                            <i class="fas fa-check-circle form-icon" style="margin-left: 10px;"></i>
                                        </div>
                                        <p id="error_username" style="color: red;"></p>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="email">Adresse mail:</label>
                                        <div class="d-flex align-items-center">
                                            <input name="email" type="email" id="email" class="form-control form-control-lg" required>
                                            <i class="fas fa-check-circle form-icon" style="margin-left: 10px;"></i>
                                        </div>
                                        <p id="error_mail" style="color: red;"></p>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="password">Mot de passe:</label>
                                        <div class="d-flex align-items-center">
                                            <input name="password" type="password" id="password" class="form-control form-control-lg" required>
                                            <i class="fas fa-check-circle form-icon" style="margin-left: 10px;"></i>
                                        </div>
                                        <p id="error_pass" style="color: red;"></p>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="password_repeat">Confirmation:</label>
                                        <div class="d-flex align-items-center">
                                            <input name="password_repeat" type="password" id="password_repeat" class="form-control form-control-lg" required>
                                            <i class="fas fa-check-circle form-icon" style="margin-left: 10px;"></i>
                                        </div>
                                        <p id="error_pass2" style="color: red;"></p>
                                        <small></small>
                                    </div>

                                    <div class="g-recaptcha" data-sitekey="6LemBREpAAAAAF2jaEPzJA-OD_FfuktX5UzhU-rR" data-action="LOGIN"></div>

                                    <br>

                                    <p id="error_msg" style="color: red;"></p>

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" id="submit-btn" class="btn btn-success btn-block btn-lg gradient-custom-4 text-white" onclick="event.preventDefault(); verifyCaptcha();">Créer</button>
                                    </div>

                                    <div id="success_msg" style="color: green;"><?php echo isset($_SESSION['success_message']) ? $_SESSION['success_message'] : ''; ?></div>

                                    <p class="text-center text-muted mt-5 mb-0">Déja membre ? <a href="connexion.php" class="fw-bold text-body"><u>connectez vous !</u></a></p>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function verifyCaptcha() {
// Check reCAPTCHA response
var response = grecaptcha.getResponse();
if (response.length == 0) {
    alert("Veuillez valider le captcha");
    return false;
}

// Check other required fields
var nom = document.getElementById('nom').value;
var prenom = document.getElementById('prenom').value;
var username = document.getElementById('username').value;
var email = document.getElementById('email').value;
var password = document.getElementById('password').value;
var password_repeat = document.getElementById('password_repeat').value;

if (nom === '' || prenom === '' || username === '' || email === '' || password === '' || password_repeat === '') {
    alert("Veuillez remplir tous les champs obligatoires.");
    return false;
}

// If all checks pass, submit the form
document.getElementById("form").submit();
}

document.addEventListener("DOMContentLoaded", function() {
    // Obtenir le message de succès
    const successMessage = document.getElementById('success_msg').innerText;
    if (successMessage) {
        const successMessageContainer = document.getElementById('success_msg');
        successMessageContainer.innerText = successMessage;
    }

    // Obtenir le message d'erreur des paramètres d'URL
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = urlParams.get('error_message');

    // Vérifier s'il y a un message d'erreur
    if (errorMessage) {
        // Afficher le message d'erreur dans un élément div
        const errorMessageContainer = document.getElementById('error_msg');
        errorMessageContainer.innerText = errorMessage;
    }

    // Vérifier la disponibilité du nom d'utilisateur
    document.getElementById('username').addEventListener('change', function() {
        var username = this.value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                console.log(response);
                if(response === ''){
                    document.getElementById('error_username').innerText = "";
                    document.getElementById('username').nextElementSibling.style.visibility = 'visible';
                } else if (response === 'exists') {
                    document.getElementById('error_username').innerText = "Le nom d'utilisateur existe déjà.";
                    document.getElementById('username').nextElementSibling.style.visibility = 'hidden';
                }
                else {
                    document.getElementById('error_username').innerText = "Le nom d'utilisateur ne peux pas être vide.";
                    document.getElementById('username').nextElementSibling.style.visibility = 'hidden';
                }
            }
        };

        xhr.open('GET', 'verif_valid.php?username=' + username, true);
        xhr.send();
    });

    // Vérifier la disponibilité et le format de l'e-mail
    document.getElementById('email').addEventListener('change', function() {
        var email = this.value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                console.log(response);
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

        xhr.open('GET', 'verif_valid.php?email=' + email, true);
        xhr.send();
    });

    // Vérifier la force du mot de passe
    document.getElementById('password').addEventListener('change', function() {
        var password = this.value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                console.log(response);
                document.getElementById('error_pass').innerText = response === 'invalid' ? "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial." : "";
                if(response == 'valid'){
                    document.getElementById('password').nextElementSibling.style.visibility = 'visible';
                } else {
                    document.getElementById('password').nextElementSibling.style.visibility = 'hidden';
                }
            }
        };

        xhr.open('GET', 'verif_valid.php?password=' + password, true);
        xhr.send();
    });

    // Vérifier la correspondance des mots de passe
    document.getElementById('password_repeat').addEventListener('change', function() {
        var password = document.getElementById('password').value;
        var password_repeat = this.value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                console.log(response);
                if(response == 'validvalid'){
                    document.getElementById('error_pass2').innerText = "";
                    document.getElementById('password_repeat').nextElementSibling.style.visibility = 'visible';
                } else {
                    document.getElementById('error_pass2').innerText = "Les deux mots de passes doivent etres identiques";
                    document.getElementById('password_repeat').nextElementSibling.style.visibility = 'hidden';
                }
            }
        };

        xhr.open('GET', 'verif_valid.php?password=' + password + '&password_repeat=' + password_repeat, true);
        xhr.send();
    });
});

// Changer l'arrière-plan
document.body.style.background = 'linear-gradient(rgba(0,0,0,0.1),#333), url("./paris.jpg")';
document.body.style.backgroundPosition = 'center';
</script>

<?php session_destroy(); ?>

</body>
</html>

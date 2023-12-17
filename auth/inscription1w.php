<?php 
session_start();
include ('header.html') ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="">
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
<body style="overflow-y: scroll;">
    <div class="container-sm" style="width: 35%;">
    <br><br><br><br>
        <form id="form" action="confirm.php" method="POST">
            <div class="form-group row">
                <div class="col">
                    <label for="nom" class="form-label">Nom</label>
                    <input name="nom" type="text" id="nom" class="form-control form-control-sm" required></input>
                </div>
                <div class="col">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input name="prenom" type="text" id="prenom" class="form-control form-control-sm" required></input>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input name="username" type="text" id="username" class="form-control form-control-sm mx-auto align-items-center" style="width: 50%; display: inline-block; left: 10%;" placeholder="museumlover70" required></input>
                <i class="fas fa-check-circle form-icon" style=" position: relative; right: -13%; visibility: hidden; color: green;"></i>
                <p id="error_username" style="color: red;"></p>
            </div>

            <div class="form-group">
                <label for="email">Adresse mail</label>
                <input name="email" type="email" id="email" class="form-control form-control-sm mx-auto align-items-center" style="width: 50%; display: inline-block; left: 10%;" placeholder="ilovemusems@gmail.com" required></input>
                <i class="fas fa-check-circle form-icon" style=" position: relative; right: -13%; visibility: hidden; color: green;"></i>
                <p id="error_mail" style="color: red;"></p>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input name="password" type="password" id="password" class="form-control form-control-sm mx-auto align-items-center" style="width: 50%; display: inline-block; left: 10%;" required></input>
                <i class="fas fa-check-circle form-icon" style=" position: relative; right: -13%; visibility: hidden; color: green;"></i>
                <p id="error_pass" style="color: red;"></p>
            </div>

            <div class="form-group">
                <label for="password_repeat">Confirmation</label>
                <input name="password_repeat" type="password" id="password_repeat" class="form-control form-control-sm mx-auto align-items-center" style="width: 50%; display: inline-block; left: 10%;" required></input>
                <i class="fas fa-check-circle form-icon" style=" position: relative; right: -13%; visibility: hidden; color: green;"></i>
                <p id="error_pass2" style="color: red;"></p>
                <small></small>
            </div>

            <div class="g-recaptcha" data-sitekey="6LemBREpAAAAAF2jaEPzJA-OD_FfuktX5UzhU-rR" data-action="LOGIN"></div>

            <br/>


            <p id="error_msg" style="color: red;"></p>


            <div class="form-group mx-auto" style="width: 50%;">
                <input type="submit" id="submit-btn" class="btn btn-primary" value="Créer un compte" onclick="event.preventDefault(); verifyCaptcha();"></input>
                 <i class="fas fa-user-plus"></i>
            </div>
               
<div id="success_msg" style="color: green;"><?php echo isset($_SESSION['success_message']) ? $_SESSION['success_message'] : ''; ?></div>

            <p class="text-center"><strong>Vous avez déjà un compte ?</strong> <a href="connexion.php">Connectez-vous</a></p>
        </form>
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
            
            const successMessage = document.getElementById('success_msg').innerText;
    if (successMessage) {
        const successMessageContainer = document.getElementById('success_msg');
        successMessageContainer.innerText = successMessage;
    }

            const urlParams = new URLSearchParams(window.location.search);
            const errorMessage = urlParams.get('error_message');

            // Vérifier s'il y a un message d'erreur
            if (errorMessage) {
                // Afficher le message d'erreur dans une balise div
                const errorMessageContainer = document.getElementById('error_msg');
                errorMessageContainer.innerText = errorMessage;
            }

            document.getElementById('username').addEventListener('change', function() {
                var username = this.value;
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText;
                        console.log(response);
                        document.getElementById('error_username').innerText = response == 'exists' ? "Le nom d'utilisateur existe déjà." : "";
                        if(response == ''){
                            document.getElementById('username').nextElementSibling.style.visibility = 'visible';
                        }else{
                            document.getElementById('username').nextElementSibling.style.visibility = 'hidden';
                        }
                    }
                };

                xhr.open('GET', 'verif_valid.php?username=' + username, true);
                xhr.send();
            });

            document.getElementById('email').addEventListener('change', function() {
                var email = this.value;
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText;
                        console.log(response);
                        document.getElementById('error_mail').innerText = response === 'exists' ? "Le mail est déjà relié à un autre compte." : "";
                        if(response == 'valid'){
                            document.getElementById('email').nextElementSibling.style.visibility = 'visible';
                        }else{
                            document.getElementById('error_mail').innerText ="Format email non valide !"
                            document.getElementById('email').nextElementSibling.style.visibility = 'hidden';
                        }
                    }
                };

                xhr.open('GET', 'verif_valid.php?email=' + email, true);
                xhr.send();
            });

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
                        }else{
                            document.getElementById('password').nextElementSibling.style.visibility = 'hidden';
                        }
                    }
                };

                xhr.open('GET', 'verif_valid.php?password=' + password, true);
                xhr.send();
            });


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
                        }else{
                            document.getElementById('error_pass2').innerText = "Les deux mots de passes doivent etres identiques";
                            document.getElementById('password_repeat').nextElementSibling.style.visibility = 'hidden';
                        }
                    }
                };

                xhr.open('GET', 'verif_valid.php?password=' + password + '&password_repeat=' + password_repeat, true);
                xhr.send();
            });

        });
    </script>
    <?php session_destroy(); ?>
</body>
</html>

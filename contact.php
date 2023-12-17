<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="icon"  type="img/ico" href="./favicon1.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="design.css">
</head>
<body>
<?php include('./header.php'); ?>
<br><br><br>
<section id="contact1">
        <br>
        <h2>Besoin d'aide ?</h2>
        <p class="question">Une question ? Une suggestion ? Votre voix compte ! Partagez avec nous, nous sommes là pour vous écouter</p>
        <div id="contact">
            <form  method="post" action="./suggestionindex.php" >
                <div class="leftandright">   
                    <div class="left-right">
                        <div class="left">
                            <div class="mb-3">
                                <label for="formGroupExampleInput1" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="formGroupExampleInput1" name="nom" placeholder="Nom">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="formGroupExampleInput2" name="prenom"  placeholder="Prénom">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput3" class="form-label">E-mail</label>
                                <input type="text" class="form-control" id="formGroupExampleInput3" name="mail" placeholder="E-MAIL">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput4" class="form-label">Suggestion</label>
                                <input type="text" class="form-control" id="formGroupExampleInput4" name="suggestion" placeholder="Votre suggestion">
                            </div>
                        </div>
                        <button>Envoyer</button>
                    </div>
                    <div class="right">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2615.298916844018!2d2.081427875933529!3d49.042939787702174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6f53e0206f165%3A0x4b40f807318bbdc8!2sCY%20Cergy%20Paris%20Universit%C3%A9%20-%20Site%20de%20Saint-Martin!5e0!3m2!1sfr!2sfr!4v1697813700197!5m2!1sfr!2sfr" height="1700" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        <br><br>
                    </div>
                </div>
            </form>
        </div>
    </section>


    <br><br>
    
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
</body>
</html>
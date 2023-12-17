<?php
    $servername = "mysql-museevasion.alwaysdata.net";
    $username = "332768";
    $password = "Projet2023m*";
    $dbname = "museevasion_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql ="SELECT * FROM utilisateur WHERE email = ? and validation_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_GET['email'], $_GET['token']);
    $stmt->execute();
    $stmt->store_result();
    $result = $stmt->num_rows;
    if ($result === 0) {
      echo '<div class="alert alert-danger" role="alert">
      Le lien de réinitialisation est invalide ou a expiré.</div>';
        exit();
    }
    ?>
  <!DOCTYPE html>
  <html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset form</title>
    <link rel="icon"  type="img/ico" href="./favicon1.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="design.css">
    <style>
      .center-form {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-top: 100px;
      }
    </style>
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
    <div class="center-form">
      <form style="width: 22rem;" method="POST">
        <div data-mdb-input-init class="form-outline mb-4">
          <label class="form-label" for="password">Mot de passe:</label>
          <input type="password" id="password" name="password" class="form-control">
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
          <label class="form-label" for="password_repeat">Répeter le mot de passe:</label>
          <input type="password" id="password_repeat" name="password_repeat" class="form-control">
        </div>
        <?php
        if (isset($_GET['status'])) {
          if($_GET['status'] == 1){
          echo '<div class="alert alert-danger" role="alert">
          Les mots de passe ne correspondent pas.</div>';}

          elseif($_GET['status'] == 2){
          echo '<div class="alert alert-danger" role="alert">
          Le mot de passe doit contenir au moins 8 caractères, dont au moins une lettre majuscule, une lettre minuscule et un caractère spécial.</div>';}

        } ?>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-block mb-4">Réinitialiser</button>
      </form>
    </div>
  </body>
  </html>
<?php } ?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      require 'verif_valid.php';
      if (checkPassword($_POST['password']) == "valid" && checkPasswordRepeat($_POST['password'], $_POST['password_repeat']) == "valid") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $radom_token = bin2hex(random_bytes(5));
        $sql = "UPDATE utilisateur SET mdp = ?, validation_token = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", password_hash($_POST['password'], PASSWORD_DEFAULT), $radom_token, $_GET['email']);
        $stmt->execute();
        $conn->close();
        header('Location: connexion.php?status=reset');
        exit();}
        elseif (checkPasswordRepeat($_POST['password'], $_POST['password_repeat']) !== "valid") {
          header('Location: reset_password_form.php?email='.$_GET['email'].'&token='.$_GET['token'].'&status=1');
          exit();
        }
        else {
          header('Location: reset_password_form.php?email='.$_GET['email'].'&token='.$_GET['token'].'&status=2');
          exit();
        }
    } ?>
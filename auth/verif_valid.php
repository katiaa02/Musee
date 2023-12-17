<?php
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

function checkUsername($username, $conn) {
    if ($username == "") {
        return "invalid";
    }
    
    $sql = "SELECT * FROM utilisateur WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "exists";
    } else {
        return "";
    }
}

function checkEmail($email, $conn) {
    if (preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $sql = "SELECT * FROM utilisateur WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return "exists";
        } else {
            return "valid";
        }
    } else {
        return "invalid";
    }
}

function checkPassword($password) {
    if (strlen($password) >= 8 && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/', $password)) {
        return "valid";
    } else {
        return "invalid";
    }
}

function checkPasswordRepeat($password, $password2) {
    if ($password2 == $password) {
        return "valid";
    } else {
        return "invalid";
    }
}

function checkRecaptcha($response, $secretKey) {
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $secretKey,
        'response' => $response
    );
    $options = array(
        'http' => array (
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $json = json_decode($result);
    return $json->success;
}



function verif_login($email, $password) {
    $servername = "mysql-museevasion.alwaysdata.net";
    $username = "332768";
    $dbpassword = "Projet2023m*";
    $dbname = "museevasion_db";

    // Create connection using PDO for better security
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM utilisateur WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a user was found and verify the password
    if ($row && password_verify($password, $row['mdp'])) {
        $conn = null;
        return $row;
    }
    echo $row['mdp'];
    // Close the connection and return false if no user found or password doesn't match
    $conn = null; // or $stmt->closeCursor();
    return null;
}




if (isset($_GET["username"])){
    $username = $_GET['username'];
    echo checkUsername($username, $conn);
}

if (isset($_GET["email"])){
    $email = $_GET['email'];
    echo checkEmail($email, $conn);
}

if (isset($_GET["password"])){
    $password = $_GET['password'];
    echo checkPassword($password);
}

if (isset($_GET["password_repeat"])){
    $password2 = $_GET['password_repeat'];
    $password = $_GET['password'];
    echo checkPasswordRepeat($password, $password2);
}

$conn->close();

<?php

// Define function to get image link from Wikipedia API
function getImageLinkByDescription($description) {
    $wikiEndpoint = 'https://en.wikipedia.org/w/api.php';

    $searchParams = array(
        'action' => 'query',
        'format' => 'json',
        'prop' => 'pageimages',
        'piprop' => 'original',
        'generator' => 'search',
        'gsrsearch' => $description,
        'gsrlimit' => 1,
    );

    $searchUrl = $wikiEndpoint . '?' . http_build_query($searchParams);

    $searchResponse = file_get_contents($searchUrl);

    $searchData = json_decode($searchResponse, true);

    if (!empty($searchData['query']['pages'])) {
        $pages = $searchData['query']['pages'];
        foreach ($pages as $page) {
            if (isset($page['original'])) {
                $imageLink = $page['original']['source'];
                return $imageLink;
            }
        }
    }

    return null;
}



function getImage($nomoff) {
    $servername = "mysql-museevasion.alwaysdata.net";
    $username = "332768";
    $password = "Projet2023m*";
    $dbname = "museevasion_db";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT url_img FROM images WHERE nom_mus = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nomoff);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imageLink = $row["url_img"];
        if ($imageLink === null) {
            $imageLink = "/photom/barre-oblique.png";
        }
    }
    else {
        $imageLink = getImageLinkByDescription($nomoff);
        if ($imageLink === null) {
            $imageLink = "/photom/barre-oblique.png";
        }
    }

    $conn->close();

    return $imageLink;
}

?>
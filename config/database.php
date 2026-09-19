<?php

// Databasegegevens
$host = 'localhost';
$dbname = 'movie_library';
$username = 'root';
$password = '';

try {

    // Verbinding maken met de database
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            // Databasefouten als exception behandelen
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

            // Resultaten als array teruggeven
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

            // Echte prepared statements gebruiken
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

} catch (PDOException $e) {

    // Technische fout in het logbestand zetten
    error_log($e->getMessage());

    // Interne serverfout
    http_response_code(500);

    // Algemene foutmelding tonen
    exit('Er is een probleem met de databaseverbinding.');
}
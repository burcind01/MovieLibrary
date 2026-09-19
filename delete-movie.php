<?php

// Verbinding maken met de database
require_once __DIR__ . '/config/database.php';

// Film-ID ophalen uit de URL
$id = (int) ($_GET['id'] ?? 0);

// Film verwijderen
$stmt = $pdo->prepare("
    DELETE FROM movies
    WHERE id = :id
");

$stmt->execute([
    'id' => $id
]);

// Terug naar de filmlijst
header('Location: index.php');
exit;
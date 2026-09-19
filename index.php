<?php

// Verbinding maken met de database
require_once __DIR__ . '/config/database.php';

// Alle films ophalen
$stmt = $pdo->query("
    SELECT *
    FROM movies
    ORDER BY title ASC
");

$movies = $stmt->fetchAll();

// Header laden
require_once __DIR__ . '/components/header.php';

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Mijn films</h1>

        <p class="text-muted">
            Bekijk en beheer je films.
        </p>
    </div>

    <a href="add-movie.php" class="btn btn-primary">
        + Film toevoegen
    </a>
</div>

<?php if (empty($movies)): ?>
    <div class="alert alert-info">
        Er staan nog geen films in je bibliotheek.
    </div>

<?php else: ?>
    <div class="row">
        <?php foreach ($movies as $movie): ?>

            <?php require __DIR__ . '/components/movie-card.php'; ?>

        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php

// Footer laden
require_once __DIR__ . '/components/footer.php';

?>
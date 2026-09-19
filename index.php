<?php

require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/navbar.php';

?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Mijn films</h1>
            <p class="text-muted">
                Bekijk en beheer je films.
            </p>
        </div>
        <a href="add.php" class="btn btn-primary">
            + Film toevoegen
        </a>

    </div>

    <div class="alert alert-info">
        Er staan nog geen films in je bibliotheek.
    </div>

<?php

require_once __DIR__ . '/components/footer.php';

?>
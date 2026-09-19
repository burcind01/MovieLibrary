<?php

// Verbinding maken met de database
require_once __DIR__ . '/config/database.php';

// Controleren of het formulier is verstuurd
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Gegevens uit het formulier ophalen
    $title = trim($_POST['title'] ?? '');
    $year = (int) ($_POST['year'] ?? 0);
    $genre = trim($_POST['genre'] ?? '');
    $rating = (int) ($_POST['rating'] ?? 0);
    $image = trim($_POST['image'] ?? '');
    $watched = isset($_POST['watched']) ? 1 : 0;

    // Controleren of de titel is ingevuld
    if ($title === '') {

        $error = 'Vul een filmtitel in.';

    // Controleren of het jaar geldig is
    } elseif ($year < 1888 || $year > (int) date('Y')) {

        $error = 'Vul een geldig filmjaar in.';

    // Controleren of de rating geldig is
    } elseif ($rating < 1 || $rating > 5) {

        $error = 'Geef een rating tussen 1 en 5.';

    // Controleren of de afbeelding een geldige URL is
    } elseif ($image === '' || !filter_var($image, FILTER_VALIDATE_URL)) {

        $error = 'Vul een geldige afbeelding-URL in.';

    } else {

        // Film toevoegen aan de database
        $stmt = $pdo->prepare("
            INSERT INTO movies (title, year, genre, rating, watched, image)
            VALUES (:title, :year, :genre, :rating, :watched, :image)
        ");

        // Waarden veilig aan de query meegeven
        $stmt->execute([
            'title' => $title,
            'year' => $year,
            'genre' => $genre,
            'rating' => $rating,
            'watched' => $watched,
            'image' => $image
        ]);

        // Terug naar de filmlijst
        header('Location: index.php');
        exit;
    }
}


// Header laden
require_once __DIR__ . '/components/header.php';

?>

<h1 class="mb-4">Film toevoegen</h1>

<?php if (isset($error)): ?>

    <!-- Foutmelding -->
    <div class="alert alert-danger">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>

<?php endif; ?>

<form method="POST">
    <!-- Titel -->
    <div class="mb-3">
        <label for="title" class="form-label">
            Titel
        </label>

        <input
            type="text"
            id="title"
            name="title"
            class="form-control"
            required
            value="<?= htmlspecialchars($_POST['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        >
    </div>

    <!-- Jaar -->
    <div class="mb-3">
        <label for="year" class="form-label">
            Jaar
        </label>
        <input
            type="number"
            id="year"
            name="year"
            class="form-control"
            min="1888"
            max="<?= date('Y') ?>"
            required
            value="<?= htmlspecialchars($_POST['year'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        >
    </div>

    <!-- Genre -->
    <div class="mb-3">
        <label for="genre" class="form-label">
            Genre
        </label>

        <input
            type="text"
            id="genre"
            name="genre"
            class="form-control"
            value="<?= htmlspecialchars($_POST['genre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        >
    </div>

    <!-- Rating -->
    <div class="mb-3">
        <label for="rating" class="form-label">
            Rating
        </label>

        <select
            id="rating"
            name="rating"
            class="form-select"
            required
        >

            <option value="">Kies een rating</option>
            <option value="1">1 / 5</option>
            <option value="2">2 / 5</option>
            <option value="3">3 / 5</option>
            <option value="4">4 / 5</option>
            <option value="5">5 / 5</option>
        </select>
    </div>

    <!-- Poster URL -->
    <div class="mb-3">

        <label for="image" class="form-label">
            Poster URL
        </label>

        <input
            type="url"
            id="image"
            name="image"
            class="form-control"
            placeholder="https://voorbeeld.nl/poster.jpg"
            required
            value="<?= htmlspecialchars($_POST['image'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        >
        <div class="form-text">
            Plak hier de URL van de filmposter.
        </div>
    </div>

    <!-- Gezien -->
    <div class="form-check mb-4">
        <input
            type="checkbox"
            id="watched"
            name="watched"
            class="form-check-input"
            <?= isset($_POST['watched']) ? 'checked' : '' ?>
        >

        <label for="watched" class="form-check-label">
            Ik heb deze film gezien
        </label>
    </div>

    <!-- Knoppen -->
    <button type="submit" class="btn btn-primary">
        Film toevoegen
    </button>

    <a href="index.php" class="btn btn-secondary">
        Annuleren
    </a>
</form>

<?php

// Footer laden
require_once __DIR__ . '/components/footer.php';

?>
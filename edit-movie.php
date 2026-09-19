<?php

// Verbinding maken met de database
require_once __DIR__ . '/config/database.php';

// Film-ID ophalen uit de URL
$id = (int) ($_GET['id'] ?? 0);

// Bestaande film ophalen
$stmt = $pdo->prepare("
    SELECT *
    FROM movies
    WHERE id = :id
");
$stmt->execute(['id' => $id]);
$movie = $stmt->fetch();

// Controleren of de film bestaat
if (!$movie) {
    http_response_code(404);
    exit('Film niet gevonden.');
}

// Controleren of het formulier is verstuurd
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $year = (int) ($_POST['year'] ?? 0);
    $genre = trim($_POST['genre'] ?? '');
    $rating = (int) ($_POST['rating'] ?? 0);
    $image = trim($_POST['image'] ?? '');
    $watched = isset($_POST['watched']) ? 1 : 0;

    // Controleren van de invoer
    if ($title === '') {
        $error = 'Vul een filmtitel in.';
    } elseif ($year < 1888 || $year > (int) date('Y')) {
        $error = 'Vul een geldig filmjaar in.';
    } elseif ($rating < 1 || $rating > 5) {
        $error = 'Geef een rating tussen 1 en 5.';
    } elseif ($image === '' || !filter_var($image, FILTER_VALIDATE_URL)) {
        $error = 'Vul een geldige afbeelding-URL in.';
    } else {
        // Film aanpassen in de database
        $stmt = $pdo->prepare("
            UPDATE movies
            SET title = :title,
                year = :year,
                genre = :genre,
                rating = :rating,
                watched = :watched,
                image = :image
            WHERE id = :id
        ");

        $stmt->execute([
            'title' => $title,
            'year' => $year,
            'genre' => $genre,
            'rating' => $rating,
            'watched' => $watched,
            'image' => $image,
            'id' => $id
        ]);

        header('Location: index.php');
        exit;
    }

    // Nieuwe waarden in het formulier laten staan
    $movie['title'] = $title;
    $movie['year'] = $year;
    $movie['genre'] = $genre;
    $movie['rating'] = $rating;
    $movie['image'] = $image;
    $movie['watched'] = $watched;
}

// Header laden
require_once __DIR__ . '/components/header.php';
?>

<h1 class="mb-4">Film aanpassen</h1>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Titel</label>
        <input
            type="text"
            id="title"
            name="title"
            class="form-control"
            required
            value="<?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>"
        >
    </div>

    <div class="mb-3">
        <label for="year" class="form-label">Jaar</label>
        <input
            type="number"
            id="year"
            name="year"
            class="form-control"
            min="1888"
            max="<?= date('Y') ?>"
            required
            value="<?= htmlspecialchars($movie['year'], ENT_QUOTES, 'UTF-8') ?>"
        >
    </div>

    <div class="mb-3">
        <label for="genre" class="form-label">Genre</label>
        <input
            type="text"
            id="genre"
            name="genre"
            class="form-control"
            value="<?= htmlspecialchars($movie['genre'], ENT_QUOTES, 'UTF-8') ?>"
        >
    </div>

    <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <select id="rating" name="rating" class="form-select" required>
            <option value="">Kies een rating</option>
            <option value="1" <?= $movie['rating'] == 1 ? 'selected' : '' ?>>1 / 5</option>
            <option value="2" <?= $movie['rating'] == 2 ? 'selected' : '' ?>>2 / 5</option>
            <option value="3" <?= $movie['rating'] == 3 ? 'selected' : '' ?>>3 / 5</option>
            <option value="4" <?= $movie['rating'] == 4 ? 'selected' : '' ?>>4 / 5</option>
            <option value="5" <?= $movie['rating'] == 5 ? 'selected' : '' ?>>5 / 5</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Poster URL</label>
        <input
            type="url"
            id="image"
            name="image"
            class="form-control"
            required
            value="<?= htmlspecialchars($movie['image'], ENT_QUOTES, 'UTF-8') ?>"
        >
    </div>

    <div class="form-check mb-4">
        <input
            type="checkbox"
            id="watched"
            name="watched"
            class="form-check-input"
            <?= $movie['watched'] ? 'checked' : '' ?>
        >
        <label for="watched" class="form-check-label">
            Ik heb deze film gezien
        </label>
    </div>

    <button type="submit" class="btn btn-primary">
        Wijzigingen opslaan
    </button>

    <a href="index.php" class="btn btn-secondary">
        Annuleren
    </a>
</form>

<?php

// Footer laden
require_once __DIR__ . '/components/footer.php';

?>
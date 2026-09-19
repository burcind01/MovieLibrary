<?php ?>
<div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm">
        <!-- Filmposter -->
        <img
            src="<?= htmlspecialchars($movie['image'], ENT_QUOTES, 'UTF-8') ?>"
            class="card-img-top movie-poster"
            alt="<?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>"
        >

        <div class="card-body">

            <!-- Titel van de film -->
            <h5 class="card-title">
                <?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>
            </h5>

            <!-- Jaar en genre -->
            <p class="card-text">
                <?= htmlspecialchars($movie['year'], ENT_QUOTES, 'UTF-8') ?>
                ·
                <?= htmlspecialchars($movie['genre'], ENT_QUOTES, 'UTF-8') ?>
            </p>

            <!-- Rating -->
            <p class="card-text">
                Rating:
                <?= htmlspecialchars($movie['rating'], ENT_QUOTES, 'UTF-8') ?>/5
            </p>

            <!-- Gezien of nog niet gezien -->
            <p class="card-text">
                <?php if ($movie['watched']): ?>
                    Gezien
                <?php else: ?>
                    Nog niet gezien
                <?php endif; ?>
            </p>

            <!-- Film aanpassen --> 
            <a
                href="edit-movie.php?id=<?= (int) $movie['id'] ?>"
                class="btn btn-primary"
            >
                Aanpassen 
            </a>
        </div>
    </div>
</div>
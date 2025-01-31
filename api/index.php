<?php
    require_once 'functions.php';
    require_once 'classes/NextMovie.php';

    $steps = isset($_GET["next"]) ? (int) $_GET["next"] : 0;
    $date = isset($_GET["date"]) ? $_GET["date"] : null;
    
    if ($steps > 0 && $date) {
        $next_movie = NextMovie::fetch_and_create_movie(API_URL, $date);
    } else {
        $next_movie = NextMovie::fetch_and_create_movie(API_URL);
    }

    if (!$next_movie) {
        die("<h1>No more upcoming MCU movies or shows.</h1>");
    }

    $movie = $next_movie->get_data();
?>

<!DOCTYPE html>
<html lang="en">

<?php render_template('head', ["title" => $movie["title"], "overview" => $movie["overview"], "poster_url" => $movie["poster_url"]]); ?>

<body>
    <div class="gradient"></div>

    <main>
        <section class="col">
            <img class="poster" src="<?= $movie["poster_url"] ?>" alt="<?= "The next MCU film is " . $movie["title"]; ?>" crossorigin="anonymous" width="350" height="380" loading="lazy">
        </section>

        <hgroup class="col">
            <h1><?= $movie["title"]; ?></h1>
            <h2><?= $next_movie->get_until_messages(); ?></h2>
            <div class="flex gap-md my">
                <div class="flex" title="Premiere">
                    <?php render_template('iconCalendar') ?>
                    <small><?= $movie["release_date"]; ?></small>
                </div>
                <div class="flex" title="Type">
                    <?php render_template('iconMovie') ?>
                    <small><?= $movie["type"]; ?></small>
                </div>
            </div>
            <p class="description my"><?= $movie["overview"]; ?></p>
            <div class="flex gap-md">
                <?php if ($steps > 0): ?>
                    <button id="previous" class="flex my link prev">
                        <?php render_template('iconArrow') ?>
                        Previous premiere
                    </button>
                <?php endif; ?>
                <?php if (!empty($movie["following_production"])): ?>
                    <a href="?next=<?= $steps + 1 ?>&date=<?= $movie["release_date"] ?>" class="flex my link next">
                        Next premiere
                        <?php render_template('iconArrow') ?>
                    </a>
                <?php endif; ?>
            </div>
        </hgroup>
    </main>

    <canvas id="canvas"></canvas>

    <script src="./script.js" defer></script>
</body>
</html>

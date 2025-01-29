<?php
    require_once 'functions.php';
    require_once 'classes/NextMovie.php';

    $next_movie = NextMovie::fetch_and_create_movie(API_URL);
    $movie = $next_movie->get_data();
?>

<!DOCTYPE html>
<html lang="en">

<?php render_template('head', ["title" => $movie["title"]]); ?>

<body>
    <div class="gradient"></div>

    <main>
        <section class="col">
            <img class="poster" src="<?= $movie["poster_url"] ?>" alt="<?= "The next MCU film is " . $movie["title"]; ?>" crossorigin="anonymous">
        </section>

        <hgroup class="col">
            <h1><?= $movie["title"]; ?></h1>
            <h5><?= $next_movie->get_until_messages(); ?></h5>
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
            <a href="#" class="flex my link">
                Next premiere 
                <?php render_template('iconArrow') ?>
            </a>
        </hgroup>
    </main>

    <canvas id="canvas"></canvas>

    <script src="./script.js"></script>
</body>
</html>

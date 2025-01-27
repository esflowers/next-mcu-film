<?php
    require_once './functions.php';
    require_once './classes/NextMovie.php';

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
            <img class="poster" src="proxy.php?url=<?= urlencode($movie["poster_url"]) ?>" alt="<?= "The next MCU film is " . $movie["title"]; ?>" crossorigin="anonymous">
        </section>

        <hgroup class="col">
            <h1><?= $movie["title"]; ?></h1>
            <h5><?= $next_movie->get_until_messages(); ?></h5>
            <p>Fecha de estreno: <?= $movie["release_date"]; ?></p>
            <p><small>El siguiente estreno es <?= $movie["following_production"]; ?></small></p>
        </hgroup>
    </main>

    <canvas id="canvas"></canvas>

    <script src="./script.js"></script>
</body>
</html>
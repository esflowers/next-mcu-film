<?php
    require_once './functions.php';
    require_once './classes/NextMovie.php';

    $next_movie = NextMovie::fetch_and_create_movie(API_URL);
    $next_movie_data = $next_movie->get_data();
?>

<!DOCTYPE html>
<html lang="en">

<?php render_template('head', ["title" => $next_movie_data["title"]]); ?>

<body>
    <main>
        <section>
            <img src="<?= $next_movie_data["poster_url"]; ?>" alt="<?= $next_movie_data["title"]; ?>" width="250">
        </section>

        <hgroup>
            <h2><?= $next_movie_data["title"]; ?></h2>
            <h4><?= $next_movie->get_until_messages(); ?></h4>
            <p>Fecha de estreno: <?= $next_movie_data["release_date"]; ?></p>
            <p><small>El siguiente estreno es <?= $next_movie_data["following_production"]; ?></small></p>
        </hgroup>
    </main> 
</body>
</html>
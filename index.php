<?php
require_once ("Movie.php");
$Movie = new MovieList();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="font-mono">
    <div id="card-movie" class="container mx-auto px-4 py-8">
        <div class="flex justify-content: flex-end mb-4">
            <p class="text-lg font-bold">[Search bar on progress...]</p>
            <!--
        <input type="text" name="orderBy" placeholder="Search bar on progress..." class="input input-bordered w-full max-w-md mb-2" />
        <button type="submit" class="btn btn-success max-w-sm mb-9">Search</button>
        -->
            <div class="dropdown dropdown-right ml-4">
                <div tabindex="0" role="button" class="btn btn-warning">Order by</div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="index.php" class='text-lg font-bold'>Default</a></li>
                    <li><a href="index.php?orderBy=title">A-Z</a></li>
                    <li><a href="index.php?orderBy=rating">Rating</a></li>
                    <li><a href="index.php?orderBy=year">Year</a></li>
                </ul>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-row gap-4">
            <?php foreach ($Movie->getBy(isset($_GET['orderBy']) ? $_GET['orderBy'] : "default") as $movieList): ?>
                <div class="card px-4 py-4 mb-2 shadow-xl bg-gray-900">
                    <div class="card-body">
                        <h1 class="card-title text-4xl font-bold text-white"><?= $movieList['title'] ?></h1>
                        <h4 class="text-xl font-semibold text-yellow-400"><?= $movieList['rating'] ?></h4>
                        <h4><?= $movieList['year'] ?></h4>
                        <h4>Genre: <?= $movieList['genre'] ?></h4>
                        <h4>Director: <?= $movieList['director'] ?></h4>
                        <h4>Actors: <?= $movieList['actors'] ?></h4>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</body>

</html>
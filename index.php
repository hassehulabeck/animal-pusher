<?php

session_start();
//var_dump($_SESSION);
$moves = 0;

if (!isset($_SESSION['grid'])) {
    $grid = [
        ["🐮", "🐸", "🐹", "🐯"],
        ["🐮", "🐸", "🐹", "🐯"],
        ["🐮", "🐸", "🐹", "🐯"],
        ["🐮", "🐸", "🐹", "🐯"],
    ];


    // Shuffle the grid, then transpose it and shuffle again.
    for ($i = 0; $i < count($grid); $i++) {
        shuffle($grid[$i]);
    }

    $grid = transpose($grid);

    // Shuffle the grid
    for ($i = 0; $i < count($grid); $i++) {
        shuffle($grid[$i]);
    }


    $_SESSION['grid'] = $grid;
    $_SESSION['moves'] = $moves;
} else {
    $grid = $_SESSION['grid'];
    $moves = $_SESSION['moves'];
}


// Transpose the array
function transpose($array)
{
    $returnArray = [];
    // Pick all the first squares from each row, make them into an array.

    // BETTER. Flatten the grid, then randomize the picking to fill another
    foreach ($array as $index => $row) {
        foreach ($row as $i => $square) {
            $returnArray[$i][$index] = $square;
        }
    }
    return $returnArray;
}

function isGridSolved($grid) {
    $isSolved = [];
    // Note. This function is only testing the rows, so it needs to be used twice, with a call to transpose in between.
    foreach($grid as $row) {
        $isSolved[] = array_all($row, function($square) use ($row) {
            return $square == $row[0];
        });
    }
    if (count(array_diff($isSolved, [true, true, true, true])) == 0) {
        return true;
    }
}

// Function that checks if a row or column is all of the same animal.
require_once __DIR__ . '/posthandling.php'



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <section id="info">
        <h4><?= $moves; ?> moves made.</h4>
        <p>The aim of the game is to manipulate the grid so that every animal type is gathered in a row or a column in the fewest moves possible.</p>
        <form action="index.php" method="post">
            <button type="submit" name="reset">New game</button>
        </form>
    </section>
    <section id="playarea">
        <form action="index.php" method="post">
            <section id="grid">
                <?php
                for ($i = 0; $i < 6; $i++) {
                ?>
                    <article class="button-<?= $i; ?>"><button type="submit" name="down" value="<?= $i; ?>">⬇️</button></article>
                <?php
                }
                foreach ($grid as $index => $row) {
                ?>
                    <article><button type="submit" name="right" value="<?= ++$index; ?>">➡️</button></article>
                    <?php
                    foreach ($row as $square) {
                    ?>
                        <article>
                            <?= $square; ?>
                        </article>
                    <?php
                    }
                    ?>
                    <article><button type="submit" name="left" value="<?= $index; ?>">⬅️</button></article>
                <?php
                }
                for ($i = 0; $i < 6; $i++) {
                ?>
                    <article class=" button-<?= $i; ?>"><button type="submit" name="up" value="<?= $i; ?>">⬆️</button></article>
                <?php
                }
                ?>
            </section>
        </form>
    </section>
</body>

</html>
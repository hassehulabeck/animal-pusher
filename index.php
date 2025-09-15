<?php

session_start();
//session_unset();





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
} else {
    $grid = $_SESSION['grid'];

    // Test to push an item into the grid
    $randomRownumber = mt_rand(1, 4);
}

// Function that reacts on buttons
if (isset($_POST)) {
    $temp = null;
    if (isset($_POST['right'])) {
        //$temp = $grid[$_POST['right'] - 1][3];
        $temp = array_pop($grid[$_POST['right'] - 1]);
        // var_dump($temp);
        array_unshift($grid[$_POST['right'] - 1], $temp);
        $_SESSION['grid'] = $grid;
    }
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

// Function that checks if a row or column is all of the same animal.




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
    <form action="/" method="post">
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
</body>

</html>
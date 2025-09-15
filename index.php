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

// Function that reacts on buttons - don't just check isset($_POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['reset'])) {
    $temp = null;
    $tempColumn = [];


    if (isset($_POST['right'])) {
        $temp = array_pop($grid[$_POST['right'] - 1]);
        array_unshift($grid[$_POST['right'] - 1], $temp);
    }
    if (isset($_POST['left'])) {
        $temp = array_shift($grid[$_POST['left'] - 1]);
        array_push($grid[$_POST['left'] - 1], $temp);
    }
    if (isset($_POST['down'])) {
        // Create an array of the items in the column
        foreach ($grid as $row) {
            $tempColumn[] = $row[$_POST['down'] - 1];
        }
        // Modify that column arraywise
        $temp = array_pop($tempColumn);
        array_unshift($tempColumn, $temp);

        // Merge the new values into the grid
        foreach ($tempColumn as $index => $item) {
            $grid[$index][$_POST['down'] - 1] = $item;
        }
    }
    if (isset($_POST['up'])) {
        // Create an array of the items in the column
        foreach ($grid as $row) {
            $tempColumn[] = $row[$_POST['up'] - 1];
        }
        // Modify that column arraywise
        $temp = array_shift($tempColumn);
        array_push($tempColumn, $temp);

        // Merge the new values into the grid
        foreach ($tempColumn as $index => $item) {
            $grid[$index][$_POST['up'] - 1] = $item;
        }
    }
    // Store the changes to the session
    $moves++;
    $_SESSION['grid'] = $grid;
    $_SESSION['moves'] = $moves;
}

if (isset($_POST['reset'])) {
    session_unset();
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
    <p><?= $moves; ?> moves made.</p>
    <form action="/" method="post">
        <button type="submit" name="reset">New game</button>
    </form>
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
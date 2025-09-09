<?php

// Build a 4 x 4 grid 
$grid = [
    ["🐮", "🐸", "🐹", "🐯"],
    ["🐮", "🐸", "🐹", "🐯"],
    ["🐮", "🐸", "🐹", "🐯"],
    ["🐮", "🐸", "🐹", "🐯"],
];

// Shuffle the grid
for ($i = 0; $i < count($grid); $i++) {
    shuffle($grid[$i]);
}

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
    <section id="grid">
        <?php
        foreach ($grid as $row) {
            foreach ($row as $square) {
        ?>
                <article>
                    <?= $square; ?>
                </article>
        <?php
            }
        }
        ?>
    </section>
</body>

</html>
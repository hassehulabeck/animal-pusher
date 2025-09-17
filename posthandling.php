<?php

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

    // Really horrible if statement. Please take some time to create a better solution!!!
    if (isGridSolved($grid)) {
        echo "Solved";
    } else {
        if (isGridSolved(transpose($grid))) {
            echo "Solved";
        }
    }
}

if (isset($_POST['reset'])) {
    session_unset();
    header('Location: index.php');
}

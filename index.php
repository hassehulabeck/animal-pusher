<?php

// Build a 4 x 4 grid 
$grid = [
    ["🐮", "🐶", "🐹", "🐯"],
    ["🐮", "🐶", "🐹", "🐯"],
    ["🐮", "🐶", "🐹", "🐯"],
    ["🐮", "🐶", "🐹", "🐯"],
];

// Shuffle the grid
for ($i=0; $i < count($grid); $i++) {    
    shuffle($grid[$i]);
}

// Display it on a web page
var_dump($grid);
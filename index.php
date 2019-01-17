<?php

require __DIR__ . './vendor/autoload.php';

$arrObj = new Hezalex\Ooe\ArrayOoe(['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4]);

// print_r($arrObj->changeKeyCase()->get());
print_r($arrObj->chunk(2)->get());
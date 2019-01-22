<?php

require __DIR__ . './vendor/autoload.php';

$arrObj = new Hezalex\Ooe\ArrayOoe(['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4]);


$closure = function ($test) {
    print_r($test);
};

print_r($arrObj->customer($closure, true)->get());
// print_r($arrObj->changeKeyCase(1)->get());
// print_r($arrObj->chunk(2)->get());
// print_r($arrObj->each(1,2,3,6,4,8,7,9)->get());
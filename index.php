<?php

require __DIR__ . './vendor/autoload.php';

$arrObj = new Hezalex\Ooe\ArrayOoe(['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4]);

$res = $arrObj->changeKeyCase();

print_r($res->get()); //
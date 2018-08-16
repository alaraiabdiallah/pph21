<?php

require_once "vendor/autoload.php";


$pph21 = new Tax\Pph21;

$pph21->setDatas([
    [
        'basic_salary' => (int)5000000,
        'tunjangan' => (int)0
    ]
]);
print_r($pph21->getResults());
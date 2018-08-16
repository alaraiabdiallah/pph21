<?php

require_once "vendor/autoload.php";


$pph21 = new Tax\Pph21;

$pph21->setDatas([
    [
        'basic_salary' => 15500000,
        'tunjangan' => 4738834
    ],
    [
        'basic_salary' => 15500000,
        'tunjangan' => 2718078

    ],
]);
print_r($pph21->getResults());
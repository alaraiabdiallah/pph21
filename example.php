<?php

require_once "vendor/autoload.php";


$pph21 = new Tax\Pph21;

$data = [
    [
        'basic_salary' => 5000000,
        'tunjangan' => 0,
    ],
    [
        'basic_salary' => 5000000,
        'tunjangan' => 0,
        'asuransi' => 0,
        'iuran' => 0
    ],
];
print_r($pph21->calculate($data));
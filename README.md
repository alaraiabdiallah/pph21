# Pph21 Library
Library untuk perhitungan pajak Pph21

cara install : 
```bash
composer require alaraiabdiallah/pph21 "dev-master"
```

contoh:
```php
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
$tax = $pph21->calculate($data);

print_r($tax);
```
<?php

use App\Kernel;
use App\Controller\CsvReader; 

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
$reader = new CsvReader;
$reader->csvReader('total', 1);

// return function (array $context) {
//     return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
// };

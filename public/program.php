<?php
use App\Kernel;
use App\Controller\CsvReader; 

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
return function (array $context) {
    $reader = new CsvReader;
    if (!isset($context['argv'][1]) OR !isset($context['argv'][2])) {
        echo 'Inform the parameters!';
    } else {
        echo $reader->csvReader($context['argv'][1], $context['argv'][2]);
    }
};
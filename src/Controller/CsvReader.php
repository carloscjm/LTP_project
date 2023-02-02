<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Highest; 
use App\Controller\Lowest; 
use App\Controller\Average; 
use App\Controller\Type; 

class CsvReader extends AbstractController
{
    public function index($what, $who) : Response {
        $reader = $this->csvReader($what, $who);
        return new Response( $reader );
    }

    public function csvReader($what, $who) {
        if (!is_numeric($who)) {
            if ($who == 'lowest') {
                $lowest  = new Lowest;
                echo $lowest->lowest($what);
            } else if ($who == 'highest') {
                $highest  = new Highest;
                echo $highest->highest($what);
            } else if ($who == 'average') {
                $average  = new Average;
                echo $average->average($what);
            } else if ($who == 'type') {
                $type  = new Type;
                echo $type->type($what);
            } else {
                return new Response();
            }
        } else {
            if ($who == 1) {
                $who = 2;
            }
            $what = strtolower($what);
            $rowNo = 1;
            $headers = [];
            $result = '';
            if (($fp = fopen("../public/ltp.csv", "r")) !== FALSE) {
                while (($row = fgetcsv($fp, 1000, ";")) !== FALSE) {
                    $num = count($row);
                    if ($rowNo == 1) {
                        for ($c=0; $c < $num; $c++) {
                            $clean = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $row[$c]));
                            $headers[$clean] = $c;
                        }
                    }
                    if ($who == $rowNo) {
                        $result =  "<p> The $what of the $who is ". $row[$headers[$what]] ." <br /></p>\n";
                    }
                    $rowNo++;
                }
                fclose($fp);
            }
            return $result;
        }
    }
}

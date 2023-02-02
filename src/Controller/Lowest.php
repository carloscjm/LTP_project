<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Lowest extends AbstractController
{
    public function index($what) : Response {
        $lowest = $this->lowest($what);
        return new Response($lowest);
    }

    public function lowest($what) {
        $what = strtolower($what);
        $rowNo = 1;
        $headers = [];
        $total = NULL;

        if (($fp = fopen("../public/ltp.csv", "r")) !== FALSE) {
            while (($row = fgetcsv($fp, 1000, ";")) !== FALSE) {
                $num = count($row);
                if ($rowNo == 1) {
                    for ($c=0; $c < $num; $c++) {
                        $clean = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $row[$c]));
                        $headers[$clean] = $c;
                    }
                } else if (is_numeric($row[$headers[$what]])) {
                    if ($row[$headers[$what]] < $total OR $total == NULL) {
                        $total = $row[$headers[$what]];
                    }
                }
                
                $rowNo++;
            }
            fclose($fp);
        }
        $total = ceil($total);
        return "<p> The lowest $what is ". $total ." <br /></p>\n";
    }
}

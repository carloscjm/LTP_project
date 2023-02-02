<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Type extends AbstractController
{
    public function index($what) : Response {
        $type = $this->type($what);
        return new Response($type);
    }

    public function type($what) {
        $what = strtolower($what);
        $rowNo = 1;
        $headers = [];
        $type = NULL;

        if (($fp = fopen("../public/ltp.csv", "r")) !== FALSE) {
            while (($row = fgetcsv($fp, 1000, ";")) !== FALSE) {
                $num = count($row);
                if ($rowNo == 1) {
                    for ($c=0; $c < $num; $c++) {
                        $clean = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $row[$c]));
                        $headers[$clean] = $c;
                    }
                } else {
                    if (is_numeric($row[$headers[$what]])) {
                        $type = 'Score';
                    } else {
                        $type = 'Level';
                    }
                }
                $rowNo++;
            }
            fclose($fp);
        }
        return "<p> The Type of the $what is a ". $type ." <br /></p>\n";
        // return "<p> The Average $what is ". $total ." <br /></p>\n";
    }
}

<?php

namespace SubjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AlgoController extends Controller
{

    public function dateInterval ($series) {

        ksort($series); $ecartMax=0;
        $annees=array_keys($series);

        for($tmp=0; $tmp<sizeof($annees)-1; $tmp++)
        {

            $ecartActuel=$annees[$tmp+1]-$annees[$tmp];

                if ($ecartActuel>$ecartMax)
                {
                    $ecartMax=$ecartActuel;
                }

        }
        return $ecartMax;
    }

}

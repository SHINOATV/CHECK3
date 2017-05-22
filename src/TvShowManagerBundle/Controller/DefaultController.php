<?php

namespace TvShowManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TvShowManagerBundle:Default:index.html.twig');
    }
}

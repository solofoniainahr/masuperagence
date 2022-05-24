<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController1 
{
    /**
     * Undocumented variable
     *
     * @var [Environment]
     */
    private $twig;
    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        return new Response($this->twig->render('pages/home1.html.twig'));
    }
}
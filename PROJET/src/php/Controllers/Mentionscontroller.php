<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;

class Mentionscontroller extends Controller
{

    public function __construct($template_)
    {
        $this->template=$template_;
    }
    protected function getPageData()
    {
        echo $this->template->render('Mentions-legales.html.twig');
    }
}
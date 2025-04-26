<?php

namespace Controller;


class LandingPage extends \Controller
{
    public function index(): void
    {
        $this->loadView('landingPage');
    }

}

$landingPage = new LandingPage();
$landingPage->index();
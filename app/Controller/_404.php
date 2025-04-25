<?php

namespace Controller;

use Controller;

class _404 extends Controller
{
    public function index(){
        $this->loadView('404');
    }
}

$P404 = new _404();
$P404->index();
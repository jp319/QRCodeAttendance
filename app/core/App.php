<?php


class App{

    public function __construct(){
        $this->loadController();
    }

    private function split(){
        $URL =  isset($_GET['url']) ? $_GET['url'] : 'loginPage';
        $URL = explode("/", $URL);
        return $URL;
    }
    private function loadController(){
        $URL = $this->split();

        $filename = "../app/Controller/".ucfirst($URL[0]).".php";

        if(file_exists($filename)){
            require $filename;
        }else{
            $filename = "../app/Controller/_404.php";
            require $filename;
        }
    }

}


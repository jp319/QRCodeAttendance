<?php

namespace Controller;

class UploadFile extends \Controller
{
    public function upload(): void
    {
        $this->loadView('uploadfile');
    }
}

$uploadFile = new UploadFile();
$uploadFile->upload();
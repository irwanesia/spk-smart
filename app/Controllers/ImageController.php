<?php

namespace App\Controllers;

class ImageController extends BaseController
{
    public function show($filename)
    {
        $path = WRITEPATH . 'uploads/' . $filename;

        // Cek file exists dan ekstensi valid
        if (!file_exists($path) || !in_array(pathinfo($filename, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Tentukan content type
        $mime = mime_content_type($path);
        header('Content-Type: ' . $mime);
        readfile($path);
        exit;
    }
}

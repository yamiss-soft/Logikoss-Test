<?php
namespace App\Helpers;


class Helper
{

    /**
     * Funcion para subir archivos solo imagenes
     *
     * @param $key
     * @param $path
     * @return string
     * @throws \Exception
     */
    public static function uploadFileImage($key, $path)
    {
        request()->file($key)->store($path);

        return request()->file($key)->hashName();
    }
}
<?php

class BaseController
{
    CONST VIEW_FOLDER_NAME = 'Views';
    CONST MODEL_FOLDER_NAME = 'Models';

    protected function view($viewPath, array $data = [])
    {
        foreach ($data as $key => $value) {
            // chuyen key truyen vao thanh ten bien.
            $$key = $value;
        }

        $viewPath = self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath).'.php';

        return require $viewPath;
    }

    protected function loadModel($pathModel)
    {
        require (self::MODEL_FOLDER_NAME . '/' . $pathModel.'.php');
    }
}
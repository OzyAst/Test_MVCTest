<?php

class View
{
    public $layout = 'layouts/main.php';

    public function generate($content, $data = [])
    {
        extract($data, EXTR_PREFIX_SAME, 'var');
        include "app/views/" . $this->layout;
    }

}
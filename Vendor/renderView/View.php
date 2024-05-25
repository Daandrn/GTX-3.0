<?php

namespace Vendor\RenderView;

require_once __DIR__ . '/../autoload.php';

class View
{
    public static function view(string $viewName, ?array $data = null): ViewRender|string 
    {
        return new ViewRender($viewName, $data);
    }
}


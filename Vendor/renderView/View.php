<?php 

namespace Vendor\renderView;

use Vendor\renderView\ViewRender;
require __DIR__.'/ViewRender.php';

function view(string $viewName, ?array $data = null): ViewRender|string {
    return new ViewRender($viewName);
}
<?php

namespace Tests;

use Vendor\Helpers\Redirect;

include __DIR__ . '/../Vendor/renderView/view.php';
include __DIR__ . '/../Vendor/Helpers/redirect.php';

class Teste
{
    public function teste()
    {
        Redirect::to('inicio');
    }
}

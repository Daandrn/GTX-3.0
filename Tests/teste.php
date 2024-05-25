<?php

namespace Tests;

use function Vendor\Helpers\redirect;
use function Vendor\renderView\view;

include __DIR__ . '/../Vendor/renderView/view.php';
include __DIR__ . '/../Vendor/Helpers/redirect.php';

class Teste
{
    public function teste()
    {
        redirect('inicio');
    }
}

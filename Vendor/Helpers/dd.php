<?php 

namespace Vendor\Helpers;

function dd(...$value) {
    echo "<pre>";
    var_dump($value);
    exit;
}

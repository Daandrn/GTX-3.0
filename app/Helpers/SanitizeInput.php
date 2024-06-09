<?php declare(strict_types=1);

namespace App\Helpers;

use Exception;

class SanitizeInput
{
    public static function make(mixed $input): mixed
    {
        if (is_string($input)) {
            $input = trim($input);
            $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, encoding: 'UTF-8');
            $input = str_replace("\0", "", $input);
            $input = preg_replace("/\s\s+/", " ", $input);
    
            return $input;
        }

        if (is_int($input)) {
            return $input;
        }

        if (is_array($input)) {
            foreach ($input as &$item) {
                $item = self::make($item);
            }

            return $input;
        }

        throw new Exception("Os dados inseridos no campo é inválido: " . print_r($input), 500);

    }
}

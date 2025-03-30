<?php

namespace App\Utils;

class Sanitizer
{
    public static function clean($input, $type = 'string')
    {
        if (!is_string($input) && !is_numeric($input)) {
            return null;
        }

        switch ($type) {
            case 'string':
                $input = trim(preg_replace('/\s+/', ' ', $input));
                return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');

            case 'integer':
                return filter_var($input, FILTER_VALIDATE_INT) !== false ? (int) $input : null;

            default:
                return $input;
        }
    }
}

<?php

namespace App\Shared\Utils;

class AttributeHelper
{
    public static function extractArgument(array $args, string $argName, int $position): mixed
    {
        if (isset($args[$argName])) {
            return $argName;
        }
        return array_values($args)[$position - 1] ?? null;
    }
}

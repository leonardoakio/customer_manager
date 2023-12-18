<?php

namespace App\Infrastructure\Helpers;

trait Mod
{
    private static function mod($dividendo, $divisor) {
        return round($dividendo - (floor($dividendo / $divisor) * $divisor));
    }
}

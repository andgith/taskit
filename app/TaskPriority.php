<?php

namespace App;

enum TaskPriority: int
{
    case P1 = 1;
    case P2 = 2;
    case P3 = 3;
    case P4 = 4;

    public function color()
    {
        return match ($this) {
            static::P1 => 'border-red-500',
            static::P2 => 'border-orange-500',
            static::P3 => 'border-yellow-500',
            static::P4 => 'border-white',
        };
    }

}


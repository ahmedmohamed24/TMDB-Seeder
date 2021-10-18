<?php

namespace App\Http\Repository;

abstract class BaseRepository
{
    public function __call($name, $arguments)
    {
        static::$model->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        static::$model->{$name}(...$arguments);
    }
}

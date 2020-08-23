<?php

namespace App\Edu;

class Edu
{
    protected $school;

    public function __construct($school)
    {
        $calssName = 'App\\Edu\\' . ucfirst(pinyin_abbr($school));

        $this->school = new $calssName();
    }

    public function __call($name, $arguments)
    {
        return $this->school->$name(...$arguments);
    }
}

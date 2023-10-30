<?php

namespace Kanekescom\Helperia\Tests\Support;

use Kanekescom\Helperia\Traits\HasMethodCaller;

class ClassExtender
{
    use HasMethodCaller;

    public $class;

    public function __construct($array = [])
    {
        $this->class = collect($array);
    }
}

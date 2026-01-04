<?php

namespace Kanekescom\Helperia\Tests\Support;

use Kanekescom\Helperia\Traits\HasMethodCaller;

/**
 * Test class extender for testing HasMethodCaller trait.
 */
class ClassExtender
{
    use HasMethodCaller;

    /**
     * The wrapped class instance.
     *
     * @var mixed
     */
    public $class;

    /**
     * Create a new class extender instance.
     *
     * @param  array<mixed>  $array
     */
    public function __construct(array $array = [])
    {
        $this->class = collect($array);
    }
}

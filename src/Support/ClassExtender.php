<?php

namespace Kanekescom\Helperia\Support;

use Kanekescom\Helperia\Traits\HasMethodCaller;

/**
 * Base class extender that allows wrapping another class
 * and forwarding method calls to it.
 *
 * @property mixed $class The wrapped class instance
 */
class ClassExtender
{
    use HasMethodCaller;

    /**
     * The wrapped class instance.
     *
     * @var mixed
     */
    protected $class;
}

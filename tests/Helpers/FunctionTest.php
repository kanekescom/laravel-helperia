<?php

it('matches public methods', function () {
    $methods = method_public(\Kanekescom\Helperia\Tests\Helpers\MyClass::class);

    expect($methods->toArray())->toMatchArray([
        1 => 'a',
    ]);
});

it('matches protected methods', function () {
    $methods = method_protected(\Kanekescom\Helperia\Tests\Helpers\MyClass::class);

    expect($methods->toArray())->toMatchArray([
        'b',
    ]);
});

it('matches private methods', function () {
    $methods = method_private(\Kanekescom\Helperia\Tests\Helpers\MyClass::class);

    expect($methods->toArray())->toMatchArray([
        'c',
    ]);
});

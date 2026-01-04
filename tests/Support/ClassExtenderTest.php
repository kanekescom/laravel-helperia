<?php

use Kanekescom\Helperia\Tests\Support\ClassExtender;

it('class is an instance of \Illuminate\Support\Collection', function () {
    $class = new ClassExtender;

    expect($class->class)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});

it('matches an array', function () {
    $class = new ClassExtender([
        'name' => 'Achmad Hadi Kurnia',
    ]);

    expect($class->toArray())->toMatchArray([
        'name' => 'Achmad Hadi Kurnia',
    ]);
});

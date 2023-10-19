<?php

it('class is an instance of \Illuminate\Support\Collection', function () {
    $class = new \Kanekescom\Helperia\Tests\Support\ClassExtender;

    expect($class->class)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});

it('matches an array', function () {
    $class = new \Kanekescom\Helperia\Tests\Support\ClassExtender([
        'name' => 'Achmad Hadi Kurnia',
    ]);

    expect($class->toArray())->toMatchArray([
        'name' => 'Achmad Hadi Kurnia',
    ]);
});

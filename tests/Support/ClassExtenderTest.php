<?php

test('Class is an instance of Laravel Collection', function () {
    $class = new \Kanekescom\Helperia\Tests\Support\ClassExtender;

    expect($class->class)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});

test('Matching an array', function () {
    $class = new \Kanekescom\Helperia\Tests\Support\ClassExtender([
        'name' => 'Achmad Hadi Kurnia',
    ]);

    expect($class->toArray())->toMatchArray([
        'name' => 'Achmad Hadi Kurnia',
    ]);
});

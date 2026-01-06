<?php

use Kanekescom\Helperia\Tests\Support\ClassExtender;

it('class is an instance of \Illuminate\Support\Collection', function () {
    $class = new ClassExtender;

    expect($class->class)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});

it('matches an array', function () {
    $class = new ClassExtender([
        'name' => 'Kanekes',
    ]);

    expect($class->toArray())->toMatchArray([
        'name' => 'Kanekes',
    ]);
});

it('can forward method calls to wrapped class', function () {
    $class = new ClassExtender(['a', 'b', 'c']);

    expect($class->count())->toBe(3);
    expect($class->first())->toBe('a');
    expect($class->last())->toBe('c');
});

it('throws BadMethodCallException for non-existent method', function () {
    $class = new ClassExtender;

    $class->nonExistentMethod();
})->throws(\BadMethodCallException::class);

it('throws BadMethodCallException for non-existent static method', function () {
    ClassExtender::nonExistentStaticMethod();
})->throws(\BadMethodCallException::class, 'Static method nonExistentStaticMethod does not exist.');

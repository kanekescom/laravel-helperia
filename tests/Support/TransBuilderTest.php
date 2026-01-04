<?php

use Kanekescom\Helperia\Support\Trans;
use Kanekescom\Helperia\Support\TransBuilder;

// TransBuilder creation tests
it('can create TransBuilder from Trans::make', function () {
    $builder = Trans::make(['Hello' => 'Halo']);

    expect($builder)->toBeInstanceOf(TransBuilder::class);
    expect($builder->get())->toBe(['Hello' => 'Halo']);
});

it('can create TransBuilder from helper function', function () {
    $builder = translations(['Hello' => 'Halo']);

    expect($builder)->toBeInstanceOf(TransBuilder::class);
});

// Chainable operations tests
it('can chain sortKeys operation', function () {
    $result = Trans::make(['B' => 'B', 'A' => 'A', 'C' => 'C'])
        ->sortKeys()
        ->get();

    expect(array_keys($result))->toBe(['A', 'B', 'C']);
});

it('can chain clean operation', function () {
    $result = Trans::make(['B' => 'B', 'A' => '', 'C' => null])
        ->clean()
        ->get();

    expect($result)->toBe(['B' => 'B']);
});

it('can chain addMissing operation', function () {
    $result = Trans::make(['Hello' => 'Halo'])
        ->addMissing(['Hello', 'World'])
        ->get();

    expect($result)->toHaveKey('World');
    expect($result['World'])->toBe('World');
});

it('can chain removeEmpty operation', function () {
    $result = Trans::make(['A' => 'A', 'B' => '', 'C' => null])
        ->removeEmpty()
        ->get();

    expect($result)->toBe(['A' => 'A']);
});

it('can chain onlyUntranslated operation', function () {
    $result = Trans::make(['Hello' => 'Hello', 'World' => 'Dunia'])
        ->onlyUntranslated()
        ->get();

    expect($result)->toBe(['Hello' => 'Hello']);
});

it('can chain onlyTranslated operation', function () {
    $result = Trans::make(['Hello' => 'Hello', 'World' => 'Dunia'])
        ->onlyTranslated()
        ->get();

    expect($result)->toBe(['World' => 'Dunia']);
});

it('can chain merge operation', function () {
    $result = Trans::make(['A' => 'A'])
        ->merge(['B' => 'B'])
        ->get();

    expect($result)->toBe(['A' => 'A', 'B' => 'B']);
});

it('can chain transform operation', function () {
    $result = Trans::make(['hello' => 'halo'])
        ->transform(fn($t) => array_map('strtoupper', $t))
        ->get();

    expect($result)->toBe(['hello' => 'HALO']);
});

it('can chain multiple operations', function () {
    $result = Trans::make(['C' => '', 'B' => 'B', 'A' => 'A'])
        ->removeEmpty()
        ->sortKeys()
        ->merge(['D' => 'D'])
        ->get();

    expect(array_keys($result))->toBe(['A', 'B', 'D']);
});

// Utility methods tests
it('can get stats from builder', function () {
    $stats = Trans::make(['Hello' => 'Hello', 'World' => 'Dunia'])
        ->stats();

    expect($stats['total'])->toBe(2);
    expect($stats['translated'])->toBe(1);
    expect($stats['untranslated'])->toBe(1);
});

it('can count translations', function () {
    $count = Trans::make(['A' => 'A', 'B' => 'B'])
        ->count();

    expect($count)->toBe(2);
});

it('can check if empty', function () {
    expect(Trans::make([])->isEmpty())->toBeTrue();
    expect(Trans::make(['A' => 'A'])->isEmpty())->toBeFalse();
});

it('can check if not empty', function () {
    expect(Trans::make([])->isNotEmpty())->toBeFalse();
    expect(Trans::make(['A' => 'A'])->isNotEmpty())->toBeTrue();
});

it('can export to json', function () {
    $json = Trans::make(['B' => 'B', 'A' => 'A'])
        ->toJson();

    expect($json)->toContain('"A": "A"');
    expect($json)->toContain('"B": "B"');
});

it('can use toArray alias', function () {
    $result = Trans::make(['A' => 'A'])
        ->toArray();

    expect($result)->toBe(['A' => 'A']);
});

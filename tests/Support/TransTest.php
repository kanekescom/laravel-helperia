<?php

use Kanekescom\Helperia\Support\Trans;

// Duplicate detection tests
it('can find duplicate keys in json', function () {
    $json = '{"Hello": "Halo", "World": "Dunia", "Hello": "Hai"}';

    expect(Trans::duplicates($json))->toHaveKey('Hello');
    expect(Trans::duplicates($json)['Hello'])->toBe(2);
});

it('can check if json has duplicates', function () {
    $withDupe = '{"Hello": "Halo", "Hello": "Hai"}';
    $noDupe = '{"Hello": "Halo", "World": "Dunia"}';

    expect(Trans::hasDuplicates($withDupe))->toBeTrue();
    expect(Trans::hasDuplicates($noDupe))->toBeFalse();
});

it('can remove duplicates from json', function () {
    $json = '{"Hello": "Halo", "World": "Dunia", "Hello": "Hai"}';
    $result = Trans::removeDuplicates($json);

    expect($result)->toBe(['Hello' => 'Hai', 'World' => 'Dunia']);
});

// Key sorting tests
it('can sort keys ascending', function () {
    $trans = ['Zebra' => 'Z', 'Apple' => 'A', 'Mango' => 'M'];
    $sorted = Trans::sortKeys($trans);

    expect(array_keys($sorted))->toBe(['Apple', 'Mango', 'Zebra']);
});

it('can sort keys descending', function () {
    $trans = ['Zebra' => 'Z', 'Apple' => 'A', 'Mango' => 'M'];
    $sorted = Trans::sortKeys($trans, false);

    expect(array_keys($sorted))->toBe(['Zebra', 'Mango', 'Apple']);
});

// Translation status tests
it('can find untranslated items', function () {
    $trans = ['Hello' => 'Hello', 'World' => 'Dunia'];
    $untranslated = Trans::untranslated($trans);

    expect($untranslated)->toBe(['Hello' => 'Hello']);
});

it('can find translated items', function () {
    $trans = ['Hello' => 'Hello', 'World' => 'Dunia'];
    $translated = Trans::translated($trans);

    expect($translated)->toBe(['World' => 'Dunia']);
});

it('can check if has untranslated', function () {
    $hasSome = ['Hello' => 'Hello', 'World' => 'Dunia'];
    $allDone = ['Hello' => 'Halo', 'World' => 'Dunia'];

    expect(Trans::hasUntranslated($hasSome))->toBeTrue();
    expect(Trans::hasUntranslated($allDone))->toBeFalse();
});

// Statistics tests
it('can get translation stats', function () {
    $trans = ['A' => 'A', 'B' => 'Bx', 'C' => 'C', 'D' => 'Dx'];
    $stats = Trans::stats($trans);

    expect($stats['total'])->toBe(4);
    expect($stats['translated'])->toBe(2);
    expect($stats['untranslated'])->toBe(2);
    expect($stats['percentage'])->toBe(50.0);
});

// Clean and export tests
it('can clean translation array', function () {
    $trans = ['B' => 'B', 'A' => '', 'C' => null, 'D' => 'Dx'];
    $cleaned = Trans::clean($trans);

    expect(array_keys($cleaned))->toBe(['B', 'D']);
    expect($cleaned)->not->toHaveKey('A');
    expect($cleaned)->not->toHaveKey('C');
});

it('can export to json', function () {
    $trans = ['B' => 'B', 'A' => 'A'];
    $json = Trans::toJson($trans);

    expect($json)->toContain('"A": "A"');
    expect($json)->toContain('"B": "B"');
});

// Key extraction tests
it('can extract keys from content', function () {
    $content = '
        __("Hello")
        @lang("World")
        trans("Yes")
        Lang::get("No")
    ';
    $keys = Trans::extractKeys($content);

    expect($keys)->toContain('Hello');
    expect($keys)->toContain('World');
    expect($keys)->toContain('Yes');
    expect($keys)->toContain('No');
});

// Missing keys tests
it('can find missing keys', function () {
    $trans = ['Hello' => 'Halo'];
    $keys = ['Hello', 'World', 'Yes'];
    $missing = Trans::missing($trans, $keys);

    expect($missing)->toContain('World');
    expect($missing)->toContain('Yes');
    expect($missing)->not->toContain('Hello');
});

it('can check if has missing keys', function () {
    $trans = ['Hello' => 'Halo'];

    expect(Trans::hasMissing($trans, ['Hello', 'World']))->toBeTrue();
    expect(Trans::hasMissing($trans, ['Hello']))->toBeFalse();
});

it('can add missing keys', function () {
    $trans = ['Hello' => 'Halo'];
    $keys = ['Hello', 'World'];
    $updated = Trans::addMissing($trans, $keys);

    expect($updated)->toHaveKey('World');
    expect($updated['World'])->toBe('World'); // Key = Value (untranslated)
});

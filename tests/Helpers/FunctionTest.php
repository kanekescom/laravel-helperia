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

it('matches all methods', function () {
    $methods = method_all(\Kanekescom\Helperia\Tests\Helpers\MyClass::class);

    expect($methods->toArray())->toContain('a');
    expect($methods->toArray())->toContain('b');
    expect($methods->toArray())->toContain('c');
});

it('can convert date format with invalid format (null)', function () {
    $convert = convert_date_format(null, 'd-m-Y', 'Y-m-d');

    expect($convert)->toBeNull();
});

it('can convert date format with invalid format ("")', function () {
    $convert = convert_date_format('', 'd-m-Y', 'Y-m-d');

    expect($convert)->toBeNull();
});

it('can convert date format with valid format', function () {
    $convert = convert_date_format('01-01-2024', 'd-m-Y', 'Y-m-d');

    expect($convert)->toBe('2024-01-01');
});

it('can convert datetime format with valid format', function () {
    $convert = convert_date_format('01-01-2024 01:01:01', 'd-m-Y H:i:s', 'Y-m-d H:i:s');

    expect($convert)->toBe('2024-01-01 01:01:01');
});

it('can parse date format with invalid format (null)', function () {
    $convert = parse_date_format(null, 'Y-m-d');

    expect($convert)->toBeNull();
});

it('can parse date format with invalid format ("")', function () {
    $convert = parse_date_format('', 'Y-m-d');

    expect($convert)->toBeNull();
});

it('can parse date format with valid format', function () {
    $convert = parse_date_format('2024-01-01', 'Y-m-d');

    expect($convert)->toBe('2024-01-01');
});

it('can parse datetime format with valid format', function () {
    $convert = parse_date_format('2024-01-01 01:01:01', 'Y-m-d H:i:s');

    expect($convert)->toBe('2024-01-01 01:01:01');
});

// Translation Helper Tests

it('can find duplicate keys in json content', function () {
    $json = '{"Hello": "Halo", "World": "Dunia", "Hello": "Hai"}';
    $duplicates = trans_duplicates($json);

    expect($duplicates)->toHaveKey('Hello');
    expect($duplicates['Hello'])->toBe(2);
});

it('can sort translation keys', function () {
    $trans = ['Zebra' => 'Zebra', 'Apple' => 'Apel', 'Mango' => 'Mangga'];
    $sorted = trans_sort_keys($trans);

    expect(array_keys($sorted))->toBe(['Apple', 'Mango', 'Zebra']);
});

it('can find untranslated items', function () {
    $trans = ['Hello' => 'Hello', 'World' => 'Dunia', 'Yes' => 'Yes'];
    $untranslated = trans_untranslated($trans);

    expect($untranslated)->toBe(['Hello' => 'Hello', 'Yes' => 'Yes']);
});

it('can check if has untranslated', function () {
    $trans = ['Hello' => 'Hello', 'World' => 'Dunia'];
    expect(trans_has_untranslated($trans))->toBeTrue();

    $allTranslated = ['Hello' => 'Halo', 'World' => 'Dunia'];
    expect(trans_has_untranslated($allTranslated))->toBeFalse();
});

it('can get translation stats', function () {
    $trans = ['Hello' => 'Hello', 'World' => 'Dunia', 'Yes' => 'Ya'];
    $stats = trans_stats($trans);

    expect($stats['total'])->toBe(3);
    expect($stats['translated'])->toBe(2);
    expect($stats['untranslated'])->toBe(1);
    expect($stats['percentage'])->toBe(66.67);
});

it('can check if has duplicates', function () {
    $jsonWithDupe = '{"Hello": "Halo", "World": "Dunia", "Hello": "Hai"}';
    expect(trans_has_duplicates($jsonWithDupe))->toBeTrue();

    $jsonNoDupe = '{"Hello": "Halo", "World": "Dunia"}';
    expect(trans_has_duplicates($jsonNoDupe))->toBeFalse();
});

it('can find translated items', function () {
    $trans = ['Hello' => 'Halo', 'World' => 'World', 'Yes' => 'Ya'];
    $translated = trans_translated($trans);

    expect($translated)->toBe(['Hello' => 'Halo', 'Yes' => 'Ya']);
});

it('can clean translation array', function () {
    $trans = ['Zebra' => 'Zebra', 'Apple' => '', 'Mango' => 'Mangga', 'Banana' => null];
    $cleaned = trans_clean($trans);

    expect(array_keys($cleaned))->toBe(['Mango', 'Zebra']); // Sorted & empty removed
    expect($cleaned)->not->toHaveKey('Apple');
    expect($cleaned)->not->toHaveKey('Banana');
});

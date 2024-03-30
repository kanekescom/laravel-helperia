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
    $convert = parse_date_format('01-01-2024', 'Y-m-d');

    expect($convert)->toBe('2024-01-01');
});

it('can parse datetime format with valid format', function () {
    $convert = parse_date_format('01-01-2024 01:01:01', 'Y-m-d H:i:s');

    expect($convert)->toBe('2024-01-01 01:01:01');
});

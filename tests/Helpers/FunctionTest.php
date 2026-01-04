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

it('can check if has duplicates', function () {
    $jsonWithDupe = '{"Hello": "Halo", "World": "Dunia", "Hello": "Hai"}';
    expect(trans_has_duplicates($jsonWithDupe))->toBeTrue();

    $jsonNoDupe = '{"Hello": "Halo", "World": "Dunia"}';
    expect(trans_has_duplicates($jsonNoDupe))->toBeFalse();
});

it('can extract translation keys from content', function () {
    $content = '
        <?php echo __("Hello World"); ?>
        {{ __("Welcome") }}
        @lang("Greeting")
        trans("Message")
        Lang::get("Title")
    ';
    $keys = trans_extract_keys($content);

    expect($keys)->toContain('Hello World');
    expect($keys)->toContain('Welcome');
    expect($keys)->toContain('Greeting');
    expect($keys)->toContain('Message');
    expect($keys)->toContain('Title');
});

it('can find missing translation keys', function () {
    $translations = ['Hello' => 'Halo', 'World' => 'Dunia'];
    $foundKeys = ['Hello', 'World', 'Yes', 'No'];

    $missing = trans_missing($translations, $foundKeys);

    expect($missing)->toContain('Yes');
    expect($missing)->toContain('No');
    expect($missing)->not->toContain('Hello');
});

it('can check if has missing keys', function () {
    $translations = ['Hello' => 'Halo'];
    $foundKeys = ['Hello', 'World'];

    expect(trans_has_missing($translations, $foundKeys))->toBeTrue();

    $allPresent = ['Hello'];
    expect(trans_has_missing($translations, $allPresent))->toBeFalse();
});

it('can find unused translation keys', function () {
    $translations = ['Hello' => 'Halo', 'World' => 'Dunia', 'Goodbye' => 'Selamat tinggal'];
    $usedKeys = ['Hello', 'World'];

    $unused = trans_unused($translations, $usedKeys);

    expect($unused)->toContain('Goodbye');
    expect($unused)->not->toContain('Hello');
    expect($unused)->not->toContain('World');
});

it('can check if has unused keys', function () {
    $translations = ['Hello' => 'Halo', 'World' => 'Dunia'];

    expect(trans_has_unused($translations, ['Hello']))->toBeTrue();
    expect(trans_has_unused($translations, ['Hello', 'World']))->toBeFalse();
});

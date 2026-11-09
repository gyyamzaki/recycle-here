<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/Support/TestRunner.php';

use Tests\Support\TestRunner;

$runner = new TestRunner();

$testFiles = [
    __DIR__ . '/Unit/AuthValidatorTest.php',
    __DIR__ . '/Unit/CollectionPointValidatorTest.php',
    __DIR__ . '/Unit/CollectionPointSearchValidatorTest.php',
];

foreach ($testFiles as $testFile) {
    $registerTests = require $testFile;
    $registerTests($runner);
}

exit($runner->finish());

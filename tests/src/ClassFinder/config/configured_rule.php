<?php

use Muz\Rector\Rule\NodeFinderForTesting;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(
        NodeFinderForTesting::class
    );
};

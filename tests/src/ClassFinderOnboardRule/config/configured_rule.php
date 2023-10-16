<?php

use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(
        RenameMethodRector::class,
        [
            new MethodCallRename(
                'Muz\Beesite\Base\Entity\Base\CandidateBase',
                'getRelatedId',
                'thisHasGoneWrong'
            ),
        ]
    );
};

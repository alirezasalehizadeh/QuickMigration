<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator;

use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\AddColumnCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\AddConstraintCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropColumnCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\ModifyColumnCommandTranslator;
use ReflectionClass;

class TableAlterTranslationManager
{
    private array $commandTranslators = [
        'AddColumnCommand' => AddColumnCommandTranslator::class,
        'ModifyColumnCommand' => ModifyColumnCommandTranslator::class,
        'DropColumnCommand' => DropColumnCommandTranslator::class,
        'AddConstraintCommand' => AddConstraintCommandTranslator::class
    ];

    public function __construct(private array $commands)
    {
    }

    public function translate(): array
    {
        return array_map(function ($command) {
            $commandTranslator = $this->commandTranslators[(new ReflectionClass($command))->getShortName()];
            return (new $commandTranslator($command))->make();
        }, $this->commands);
    }
}

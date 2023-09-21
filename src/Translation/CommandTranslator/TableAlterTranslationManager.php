<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator;

use ReflectionClass;

class TableAlterTranslationManager
{
    public function __construct(private array $commands)
    {
    }

    public function translate(): array
    {
        return array_map(function ($command) {
            $commandTranslatorMethod = lcfirst((new ReflectionClass($command))->getShortName()) . "Translator";
            return (new CommandTranslator($command))->$commandTranslatorMethod();
        }, $this->commands);
    }
}

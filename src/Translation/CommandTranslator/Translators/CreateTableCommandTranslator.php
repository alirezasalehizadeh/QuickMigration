<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\CommandTranslatorInterface;

class CreateTableCommandTranslator implements CommandTranslatorInterface
{

    public function __construct(private Command $command)
    {
    }

    public function make(): string
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['database'],
            $this->command->getIncludes()['table'],
            implode(',', $this->command->getIncludes()['sqlCommands']),
        );
    }
}

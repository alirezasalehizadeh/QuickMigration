<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\ColumnTranslateManager;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\CommandTranslatorInterface;

class AddConstraintCommandTranslator implements CommandTranslatorInterface
{

    public function __construct(private Command $command)
    {
    }

    public function make(): string
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['table'],
            (new ColumnTranslateManager)->translate([$this->command->getIncludes()['column']])[0],
        );
    }
}

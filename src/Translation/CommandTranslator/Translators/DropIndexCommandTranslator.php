<?php
namespace Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\CommandTranslatorInterface;


class DropIndexCommandTranslator implements CommandTranslatorInterface
{

    public function __construct(
        private Command $command
    ){
        $this->command = $command;    
    }
    
    public function make():string
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['table'],
            $this->command->getIncludes()['name'],
        );
    }
}

<?php


namespace Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\ColumnTranslateManager;

class CommandTranslator
{
    public function __construct(private Command $command)
    {
    }

    public function addColumnCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['table'],
            (new ColumnTranslateManager)->translate([$this->command->getIncludes()['column']])[0],
        );
    }

    public function addConstraintCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['table'],
            (new ColumnTranslateManager)->translate([$this->command->getIncludes()['column']])[0],
        );
    }

    public function createIndexCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['name'],
            $this->command->getIncludes()['database'],
            $this->command->getIncludes()['table'],
            implode(",", $this->command->getIncludes()['columns']),
        );
    }

    public function dropIndexCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['database'],
            $this->command->getIncludes()['table'],
            $this->command->getIncludes()['name'],
        );
    }

    public function createTableCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['database'],
            $this->command->getIncludes()['table'],
            implode(',', $this->command->getIncludes()['sqlCommands']),
        );
    }

    public function dropTableCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['database'],
            $this->command->getIncludes()['table'],
        );
    }

    public function dropColumnCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['table'],
            $this->command->getIncludes()['column'],
        );
    }

    public function dropIfExistsTableCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['database'],
            $this->command->getIncludes()['table'],
        );
    }

    public function modifyColumnCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['table'],
            (new ColumnTranslateManager)->translate([$this->command->getIncludes()['column']])[0],
        );
    }

    public function dropCheckConstraintCommandTranslator()
    {
        return sprintf(
            $this->command->getPattern(),
            $this->command->getName(),
            $this->command->getIncludes()['table'],
            $this->command->getIncludes()['name'],
        );
    }
}

<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Command\Commands\AddColumnCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\AddConstraintCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropCheckConstraintCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropColumnCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\ModifyColumnCommand;

class TableAlter
{

    private array $commands = [];

    public function __construct(private string $table)
    {
    }

    public function addColumn(Column $column)
    {
        return $this->commands[] = (new AddColumnCommand($this->table, $column))->getCommand();
    }

    public function dropColumn(string $column)
    {
        return $this->commands[] = (new DropColumnCommand($this->table, $column))->getCommand();
    }

    public function modifyColumn(Column $column)
    {
        return $this->commands[] = (new ModifyColumnCommand($this->table, $column))->getCommand();
    }

    public function addConstraint(Column $column)
    {
        return $this->commands[] = (new AddConstraintCommand($this->table, $column))->getCommand();
    }

    public function dropCheck(string $name)
    {
        return $this->commands[] = (new DropCheckConstraintCommand($this->table, $name))->getCommand();
    }

    public function done()
    {
        return $this->commands;
    }
}

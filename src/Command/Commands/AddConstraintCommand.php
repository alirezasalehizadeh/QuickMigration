<?php

namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;
use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;
use Alirezasalehizadeh\QuickMigration\Structure\Column;

class AddConstraintCommand extends Command implements CommandInterface
{

    protected string $pattern = "%s `%s` ADD CONSTRAINT %s";

    public function __construct(private string $table, private Column $column)
    {
    }

    public function getCommand(): self
    {
        return $this
            ->setName(EnumsCommand::AlterTable)
            ->setIncludes(get_object_vars($this));
    }
}

<?php

namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;
use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;

class DropIfExistsTableCommand extends Command implements CommandInterface
{

    protected string $pattern = "%s `%s`.`%s`";

    public function __construct(private string $database, private string $table)
    {
    }

    public function getCommand(): self
    {
        return $this
            ->setName(EnumsCommand::DropTableIfExists)
            ->setIncludes(get_object_vars($this));
    }
}

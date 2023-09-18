<?php

namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;
use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;

class CreateTableCommand extends Command implements CommandInterface
{

    protected $pattern = "%s `%s`.`%s` (%s)";

    public function __construct(private string $database, private string $table, private array $sqlCommands)
    {
    }

    public function getCommand(): self
    {
        return $this
            ->setName(EnumsCommand::Create)
            ->setIncludes(get_object_vars($this));
    }
}

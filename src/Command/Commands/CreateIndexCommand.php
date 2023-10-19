<?php

namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;
use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;

class CreateIndexCommand extends Command implements CommandInterface
{

    protected string $pattern = "%s %s ON %s.%s(%s)";

    public function __construct(private string $name, private string $database, private string $table, private array $columns)
    {
    }

    public function getCommand(): self
    {
        return $this
            ->setName(EnumsCommand::CreateIndex)
            ->setIncludes(get_object_vars($this));
    }
}

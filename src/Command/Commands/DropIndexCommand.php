<?php

namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;
use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;

class DropIndexCommand extends Command implements CommandInterface
{

    protected $pattern = "%s %s DROP INDEX %s";

    public function __construct(private string $name, private string $table)
    {
    }

    public function getCommand(): self
    {
        return $this
            ->setName(EnumsCommand::AlterTable)
            ->setPattern($this->pattern)
            ->setIncludes([
                'name' => $this->name,
                'table' => $this->table,
            ]);
    }
}

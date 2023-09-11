<?php

namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;
use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;

class CreateIndexCommand extends Command implements CommandInterface
{

    protected $pattern = "%s %s ON %s(%s)";

    public function __construct(private string $name, private string $table, private array $columns)
    {
    }

    public function getCommand(): self
    {
        return $this
            ->setName(EnumsCommand::CreateIndex)
            ->setPattern($this->pattern)
            ->setIncludes([
                'name' => $this->name,
                'table' => $this->table,
                'columns' => $this->columns,
            ]);
    }
}

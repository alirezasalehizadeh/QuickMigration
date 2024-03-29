<?php

namespace Alirezasalehizadeh\QuickMigration\Command;

use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;

class Command
{

    private $name;

    protected string $pattern = '';

    private array $includes = [];

    public function getName()
    {
        return $this->name->value;
    }

    public function setName(EnumsCommand $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getIncludes()
    {
        return $this->includes;
    }

    public function setIncludes(array $includes)
    {
        $this->includes = $includes;

        return $this;
    }
}

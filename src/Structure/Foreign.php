<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Structure\Column;

class Foreign extends Column
{

    private $reference;

    private $on;

    private $cascadeOnDelete, $cascadeOnUpdate;

    public function getReference()
    {
        return $this->reference;
    }

    public function reference(string $column)
    {
        $this->reference = $column;

        return $this;
    }

    public function getOn()
    {
        return $this->on;
    }

    public function on(string $table)
    {
        $this->on = $table;

        return $this;
    }

    public function getCascadeOnDelete()
    {
        return $this->cascadeOnDelete;
    }

    public function cascadeOnDelete(bool $onDelete = true)
    {
        $this->cascadeOnDelete = $onDelete;
        return $this;
    }

    public function getCascadeOnUpdate()
    {
        return $this->cascadeOnUpdate;
    }

    public function cascadeOnUpdate(bool $onUpdate = true)
    {
        $this->cascadeOnUpdate = $onUpdate;
        return $this;

    }
}

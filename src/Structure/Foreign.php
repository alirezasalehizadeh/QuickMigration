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

    public function reference($table)
    {
        $this->reference = $table;

        return $this;
    }

    public function getOn()
    {
        return $this->on;
    }

    public function on($column)
    {
        $this->on = $column;

        return $this;
    }

    public function getCascadeOnDelete()
    {
        return $this->cascadeOnDelete;
    }

    public function cascadeOnDelete($onDelete = true)
    {
        $this->cascadeOnDelete = $onDelete;
        return $this;
    }

    public function getCascadeOnUpdate()
    {
        return $this->cascadeOnUpdate;
    }

    public function cascadeOnUpdate($onUpdate = true)
    {
        $this->cascadeOnUpdate = $onUpdate;
        return $this;

    }
}

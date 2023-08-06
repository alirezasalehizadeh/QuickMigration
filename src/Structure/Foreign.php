<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Foreign as EnumsForeign;
use Alirezasalehizadeh\QuickMigration\Structure\Column;

class Foreign extends Column
{

    private $reference;

    private $on;

    private $onDelete, $onUpdate;

    public function reference(string $column)
    {
        $this->reference = $column;

        return $this;
    }

    public function on(string $table)
    {
        $this->on = $table;

        return $this;
    }

    public function onDelete(EnumsForeign $option)
    {
        $this->onDelete = $option;

        return $this;
    }

    public function onUpdate(EnumsForeign $option)
    {
        $this->onUpdate = $option;

        return $this;
    }

    public function cascadeOnDelete()
    {
        return $this->onDelete(EnumsForeign::Cascade);
    }

    public function cascadeOnUpdate()
    {
        return $this->onUpdate(EnumsForeign::Cascade);
    }

    public function restrictOnDelete()
    {
        return $this->onDelete(EnumsForeign::Restrict);
    }

    public function restrictOnUpdate()
    {
        return $this->onUpdate(EnumsForeign::Restrict);
    }

    public function noActionOnDelete()
    {
        return $this->onDelete(EnumsForeign::NoAction);
    }

    public function noActionOnUpdate()
    {
        return $this->onUpdate(EnumsForeign::NoAction);
    }

    public function setNullOnDelete()
    {
        return $this->onDelete(EnumsForeign::SetNull);
    }

    public function setNullOnUpdate()
    {
        return $this->onUpdate(EnumsForeign::SetNull);
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getOn()
    {
        return $this->on;
    }

    public function getOnDelete()
    {
        return $this->onDelete?->value;
    }

    public function getOnUpdate()
    {
        return $this->onUpdate?->value;
    }
}

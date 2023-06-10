<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Index;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Enums\Attribute;

class Column
{
    private $name, $type, $length;

    private $index;

    private $attribute;

    private $default;

    private $nullable;

    private $autoIncrement;

    public function __construct(string $name, Type $type, int $length = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->length = $length;
    }

    public function nullable(bool $status = true)
    {
        $this->nullable = $status;
        return $this;
    }

    public function autoIncrement(bool $status = true)
    {
        $this->autoIncrement = $status;
        return $this;
    }

    public function index(Index $index = null)
    {
        $this->index = $index;
        return $this;
    }

    public function default(mixed $default)
    {
        if (is_callable($default)) {
            $this->default = $default();
        } else {
            $this->default = ($this->nullable) ? "NULL" : $default;
        }

        return $this;
    }

    public function attribute(Attribute $attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function primary()
    {
        return $this->index(Index::Primary);
    }

    public function unique()
    {
        return $this->index(Index::Unique);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type->value;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getIndex()
    {
        return $this->index?->value;
    }

    public function getAttribute()
    {
        return $this->attribute?->value;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getNullable()
    {
        return $this->nullable;
    }

    public function getAutoIncrement()
    {
        return $this->autoIncrement;
    }
}

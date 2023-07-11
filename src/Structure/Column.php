<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Index;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Enums\Attribute;

class Column
{
    private $name, $type, $value;

    private $index = [];

    private $attribute;

    private $default;

    private $nullable;

    private $autoIncrement;

    private $foreignKey;

    public function __construct(string $name, Type|string $type, mixed $value = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
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

    public function setIndex(Index $index = null)
    {
        $this->index[] = $index;
        return $this;
    }

    public function default(mixed $default)
    {
        $this->default = is_callable($default) ? $default() : $default;
        return $this;
    }

    public function attribute(Attribute $attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function primary()
    {
        return $this->setIndex(Index::Primary);
    }

    public function unique()
    {
        return $this->setIndex(Index::Unique);
    }

    public function unsigned()
    {
        return $this->attribute(Attribute::Unsigned);
    }

    public function index()
    {
        return $this->setIndex(Index::Index);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type instanceof Type
            ? $this->type->value
            : $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function getAttribute()
    {
        return $this->attribute;
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

    public function setForeignKey(array $references)
    {
        $this->foreignKey = $references;

        return $this;
    }

    public function getForeignKey()
    {
        return $this->foreignKey;
    }
}

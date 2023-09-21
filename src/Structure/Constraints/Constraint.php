<?php


namespace Alirezasalehizadeh\QuickMigration\Structure\Constraints;

use Alirezasalehizadeh\QuickMigration\Enums\Attribute;
use Alirezasalehizadeh\QuickMigration\Enums\Index;

trait Constraint
{

    private $index = [];

    private $attribute;

    private $default;

    private $nullable;

    private $autoIncrement;

    private $after;

    public function nullable(bool $nullable = true)
    {
        $this->nullable = $nullable;
        return $this;
    }

    public function autoIncrement(bool $autoIncrement = true)
    {
        $this->autoIncrement = $autoIncrement;
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

    public function after(string $column)
    {
        $this->after = $column;
        return $this;
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

    public function getAfter()
    {
        return $this->after;
    }
}

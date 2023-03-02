<?php
namespace Alirezasalehizadeh\QuickMigration\Translation;

use Alirezasalehizadeh\QuickMigration\Enums\Index;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Column;

class MySqlTranslator extends Translator
{

    protected $column;

    protected $pattern = "`%s` %s %s %s %s %s %s";

    public function __construct(Column $column)
    {
        $this->column = $column;
    }

    public function make(): string
    {
        return sprintf($this->pattern,
            $this->matchName(),
            $this->matchType(),
            $this->matchAttribute(),
            $this->matchNullable(),
            $this->matchDefault(),
            $this->matchAutoIncrement(),
            $this->matchIndex(),
        );
    }

    protected function matchName()
    {
        return $this->column->getName();

    }

    protected function matchType()
    {

        $type = $this->column->getType();

        if ($type === Type::Varchar->value) {
            $type .= "({$this->column->getLength()})";
        }

        return $type;

    }

    protected function matchNullable()
    {
        return $this->column->getNullable() ? "NULL" : "NOT NULL";
    }

    protected function matchAutoIncrement()
    {
        return $this->column->getAutoIncrement() ? "AUTO_INCREMENT" : '';
    }

    protected function matchDefault()
    {
        return $this->column->getDefault() ? ("DEFAULT " . $this->column->getDefault()) : '';

    }

    protected function matchAttribute()
    {
        return $this->column->getAttribute();
    }

    protected function matchIndex()
    {
        $index = '';
        if ($this->column->getIndex() === Index::Primary->value) {
            $index .= " PRIMARY KEY ";
        }
        if ($this->column->getIndex() === Index::Unique->value) {
            $index .= " UNIQUE ";
        }
        return $index;
    }

}

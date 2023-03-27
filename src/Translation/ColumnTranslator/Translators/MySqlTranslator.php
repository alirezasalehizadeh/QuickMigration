<?php
namespace Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\Translators;

use Alirezasalehizadeh\QuickMigration\Enums\Index;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Column;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\ColumnTranslator;

class MySqlTranslator extends ColumnTranslator
{

    protected $column;

    protected $pattern = "`%s` %s %s %s %s %s %s";

    public function setColumn(Column $column)
    {
        $this->column = $column;
        return $this;
    }

    public function make(): string
    {
        return trim(preg_replace('/\s+/', ' ', sprintf($this->pattern,
            $this->matchName(),
            $this->matchType(),
            $this->matchAttribute(),
            $this->matchNullable(),
            $this->matchDefault(),
            $this->matchAutoIncrement(),
            $this->matchIndex(),
        )));
    }

    public function matchName()
    {
        return $this->column->getName();

    }

    public function matchType()
    {

        $type = $this->column->getType();

        if ($type === Type::Varchar->value) {
            $type .= "({$this->column->getLength()})";
        }

        return $type;

    }

    public function matchNullable()
    {
        return $this->column->getNullable() ? "NULL" : "NOT NULL";
    }

    public function matchAutoIncrement()
    {
        return $this->column->getAutoIncrement() ? "AUTO_INCREMENT" : '';
    }

    public function matchDefault()
    {
        return $this->column->getDefault() ? ("DEFAULT " . $this->column->getDefault()) : '';

    }

    public function matchAttribute()
    {
        return $this->column->getAttribute();
    }

    public function matchIndex()
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

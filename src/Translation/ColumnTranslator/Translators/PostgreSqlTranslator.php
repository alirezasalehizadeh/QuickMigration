<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\Translators;

use Alirezasalehizadeh\QuickMigration\Enums\Index;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Column;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\ColumnTranslator;

class PostgreSqlTranslator extends ColumnTranslator
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
        return trim(preg_replace('/\s+/', ' ', sprintf(
            $this->pattern,
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
            if($this->column->getValue() === null){
                $type .= "(255)";
                return $type;
            }
            $type .= "({$this->column->getValue()})";
        }

        if ($type === Type::Enum->value) {
            $values = implode(',', $this->column->getValue());
            $type .= "({$values})";
        }

        return $type;
    }

    public function matchNullable()
    {
        return $this->column->getNullable() ? "NULL" : "NOT NULL";
    }

    public function matchAutoIncrement()
    {
        return $this->column->getAutoIncrement() ? "AUTO_INCREMENT" : null;
    }

    public function matchDefault()
    {
        $default = $this->column->getDefault();

        return ($this->column->getDefault() && !$this->column->getNullable()) ? "DEFAULT('{$default}')" : null;
    }

    public function matchAttribute()
    {
        return $this->column->getAttribute()?->value;
    }

    public function matchIndex()
    {
        $result = '';

        foreach ($this->column->getIndex() as $index) {

            if ($index === Index::Primary) {
                $result .= " PRIMARY KEY ";
            }

            if ($index === Index::Unique) {
                $result .= " UNIQUE ";
            }
        }

        // The INDEX statement are out of loop because this separate from other index with comma
        if (in_array(Index::Index, $this->column->getIndex())) {
            $result .= ", INDEX({$this->column->getName()}) ";
        }

        return $result;
    }
}

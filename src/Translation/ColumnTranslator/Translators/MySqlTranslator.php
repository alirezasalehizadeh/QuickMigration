<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\Translators;

use Alirezasalehizadeh\QuickMigration\Enums\Index;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Column;
use Alirezasalehizadeh\QuickMigration\Structure\Foreign;
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
        if ($this->column instanceof Foreign) {
            return $this->matchForeignKey();
        }

        return $this->trimString(sprintf(
            $this->pattern,
            $this->matchName(),
            $this->matchType(),
            $this->matchAttribute(),
            $this->matchNullable(),
            $this->matchDefault(),
            $this->matchAutoIncrement(),
            $this->matchIndex(),
        ));
    }

    public function matchName()
    {
        return $this->column->getName();
    }

    public function matchType()
    {

        $type = $this->column->getType();

        if ($type === Type::Varchar->value) {
            $type .= "({$this->column->getValue()})";
        }

        if ($type === Type::Enum->value) {
            $values = implode("','", $this->column->getValue());
            $type .= "('{$values}')";
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
        $columnIndex = '';

        foreach ($this->column->getIndex() as $index) {

            if ($index === Index::Primary) {
                $columnIndex .= " PRIMARY KEY ";
            }

            if ($index === Index::Unique) {
                $columnIndex .= " UNIQUE ";
            }
        }

        // The INDEX statement are out of loop because this separate from other index with comma
        if (in_array(Index::Index, $this->column->getIndex())) {
            $columnIndex .= ", INDEX({$this->column->getName()}) ";
        }

        return $columnIndex;
    }

    public function matchForeignKey()
    {
        return $this->trimString(sprintf(
            "FOREIGN KEY (%s) REFERENCES `%s`(%s) %s %s",
            $this->column->getName(),
            $this->column->getOn(),
            $this->column->getReference(),
            $this->column->getCascadeOnUpdate() ? "ON UPDATE CASCADE" : null,
            $this->column->getCascadeOnDelete() ? "ON DELETE CASCADE" : null,
        ));
    }

    private function trimString(string $string){
        return trim(preg_replace('/\s+/', ' ', $string));
    }
}

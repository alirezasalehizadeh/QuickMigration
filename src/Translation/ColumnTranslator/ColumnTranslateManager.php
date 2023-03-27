<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator;

class ColumnTranslateManager
{

    private $translator;

    private $translatedColumns = [];

    public function __construct($translator = null)
    {
        $translatorObj = new ColumnTranslator;

        $this->translator = in_array($translator, $translatorObj->availableTranslators)
        ? new $translatorObj->availableTranslators[$translator]
        : new $translatorObj->availableTranslators["MySql"];
    }

    public function translate(array $columns): array
    {
        foreach ($columns as $column) {
            $this->translatedColumns[] = $this->translator->setColumn($column)->make();
        }
        return $this->translatedColumns;
    }
}

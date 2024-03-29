<?php

namespace Alirezasalehizadeh\QuickMigration\Test\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\ColumnFactory;
use PHPUnit\Framework\TestCase;
use Alirezasalehizadeh\QuickMigration\Structure\Structure;
use Alirezasalehizadeh\QuickMigration\Structure\TableAlter;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\TableAlterTranslationManager;

class StructureAlterTest extends TestCase
{
    /** @test */
    public function canChangeTableTest()
    {
        $commands = Structure::change('test', function (TableAlter $alter) {
            $alter->addColumn(ColumnFactory::create('foo', Type::Varchar));
            $alter->addConstraint(ColumnFactory::foreign('foo', Type::Varchar)->reference('id')->on('bar')->cascadeOnDelete()->restrictOnUpdate());
            $alter->modifyColumn(ColumnFactory::create('foo', Type::Text));
            $alter->dropColumn('foo');
        });

        [$addColumn, $addConstraint, $modifyColumn, $dropColumn] = (new TableAlterTranslationManager($commands))->translate();

        $this->assertSame("ALTER TABLE `test` ADD `foo` VARCHAR(255) NOT NULL", $addColumn);
        $this->assertSame("ALTER TABLE `test` ADD CONSTRAINT FOREIGN KEY (foo) REFERENCES `bar`(id) ON UPDATE RESTRICT ON DELETE CASCADE", $addConstraint);
        $this->assertSame("ALTER TABLE `test` MODIFY COLUMN `foo` TEXT NOT NULL", $modifyColumn);
        $this->assertSame("ALTER TABLE `test` DROP COLUMN foo", $dropColumn);
    }
}

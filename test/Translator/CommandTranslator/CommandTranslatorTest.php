<?php

namespace Alirezasalehizadeh\QuickMigration\Test\Translator\CommandTranslator;

use Alirezasalehizadeh\QuickMigration\Command\Commands\CreateTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropIfExistsTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropTableCommand;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\CreateTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropIfExistsTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropTableCommandTranslator;
use PHPUnit\Framework\TestCase;

class CommandTranslatorTest extends TestCase
{

    private string $database = 'foo';
    private string $table = 'bar';

    /** @test */
    public function canMakeCreateTableCommandTest()
    {
        $command = (new CreateTableCommand($this->database, $this->table, [
            '`id` INT NOT NULL'
        ]))->getCommand();

        $sql = (new CreateTableCommandTranslator($command))->make();

        $this->assertSame("CREATE TABLE `foo`.`bar` (`id` INT NOT NULL)", $sql);
    }

    /** @test */
    public function canMakeDropTableCommandTest()
    {
        $command = (new DropTableCommand($this->database, $this->table))->getCommand();

        $sql = (new DropTableCommandTranslator($command))->make();

        $this->assertSame("DROP TABLE `foo`.`bar`", $sql);
    }

    /** @test */
    public function canMakeDropIfExistsTableCommandTest()
    {
        $command = (new DropIfExistsTableCommand($this->database, $this->table))->getCommand();

        $sql = (new DropIfExistsTableCommandTranslator($command))->make();

        $this->assertSame("DROP TABLE IF EXISTS `foo`.`bar`", $sql);
    }
}

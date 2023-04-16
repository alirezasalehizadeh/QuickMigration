<?php
namespace Alirezasalehizadeh\QuickMigration\Test\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Attribute;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Structure;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\ColumnTranslateManager;
use PHPUnit\Framework\TestCase;

class StructureBuilderTest extends TestCase
{

    /** @test */
    public function createNullableColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->string('foo', 100)->nullable();

        $sql = (new ColumnTranslateManager())->translate([$column]);

        $this->assertSame("`foo` VARCHAR(100) NULL", $sql[0]);
    }

    /** @test */
    public function createColumnWithAutoIncrementTest()
    {
        $structure = new Structure('test');

        $column = $structure->number('foo', Type::Int)->autoIncrement();

        $sql = (new ColumnTranslateManager())->translate([$column]);

        $this->assertSame("`foo` INT NOT NULL AUTO_INCREMENT", $sql[0]);
    }

    /** @test */
    public function createColumnWithDefaultValueTest()
    {
        $structure = new Structure('test');

        $column = $structure->number('foo', Type::Tinyint)->default(1);

        $sql = (new ColumnTranslateManager())->translate([$column]);

        $this->assertSame("`foo` TINYINT NOT NULL DEFAULT 1", $sql[0]);
    }

    /** @test */
    public function createColumnWithUnsignedAttributeTest()
    {
        $structure = new Structure('test');

        $column = $structure->number('foo', Type::Bigint)->attribute(Attribute::Unsigned);

        $sql = (new ColumnTranslateManager())->translate([$column]);

        $this->assertSame("`foo` BIGINT UNSIGNED NOT NULL", $sql[0]);
    }

    /** @test */
    public function createNotNullUniqueVarcharTypeColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->string('foo', 100)->unique();

        $sql = (new ColumnTranslateManager())->translate([$column]);

        $this->assertSame("`foo` VARCHAR(100) NOT NULL UNIQUE", $sql[0]);
    }

    /** @test */
    public function createTimestampTypeColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->timestamp('foo');

        $sql = (new ColumnTranslateManager())->translate([$column]);

        $this->assertSame("`foo` TIMESTAMP NOT NULL", $sql[0]);
    }

    /** @test */
    public function createJsonTypeColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->json('foo');

        $sql = (new ColumnTranslateManager())->translate([$column]);

        $this->assertSame("`foo` JSON NOT NULL", $sql[0]);
    }

    /** @test */
    public function createPrimaryColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->number('foo', Type::Int)->primary();

        $sql = (new ColumnTranslateManager())->translate([$column]);

        $this->assertSame("`foo` INT NOT NULL PRIMARY KEY", $sql[0]);
    }

    /** @test */
    public function createNullableColumnHaveNullDefaultValueTest()
    {
        $structure = new Structure('test');

        $column = $structure->number('foo', Type::Int)->nullable()->default(1);

        $sql = (new ColumnTranslateManager())->translate([$column]);

        $this->assertSame("`foo` INT NULL DEFAULT NULL", $sql[0]);
    }

    /** @test */
    public function createNullableIntTypeColumnAndUniqueStringTypeColumnTest()
    {
        $structure = new Structure('test');

        $structure->number('foo', Type::Int)->nullable();
        $structure->string('bar', 100)->unique();

        $columns = $structure->done();

        $sql = (new ColumnTranslateManager())->translate($columns[0]);

        $this->assertSame("`foo` INT NULL , `bar` VARCHAR(100) NOT NULL UNIQUE", "{$sql[0]} , {$sql[1]}");
    }

}

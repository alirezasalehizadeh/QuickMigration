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

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` VARCHAR(100) NULL", $sql);
    }

    /** @test */
    public function createColumnWithAutoIncrementTest()
    {
        $structure = new Structure('test');

        $column = $structure->number('foo')->autoIncrement();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` INT NOT NULL AUTO_INCREMENT", $sql);
    }

    /** @test */
    public function createColumnWithDefaultValueTest()
    {
        $structure = new Structure('test');

        $column = $structure->tinyInt('foo')->default(1);

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` TINYINT NOT NULL DEFAULT('1')", $sql);
    }

    /** @test */
    public function createColumnWithUnsignedAttributeTest()
    {
        $structure = new Structure('test');

        $column = $structure->bigInt('foo')->unsigned();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` BIGINT UNSIGNED NOT NULL", $sql);
    }

    /** @test */
    public function createNotNullUniqueVarcharTypeColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->string('foo', 100)->unique();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` VARCHAR(100) NOT NULL UNIQUE", $sql);
    }

    /** @test */
    public function createTimestampTypeColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->timestamp('foo');

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` TIMESTAMP NOT NULL", $sql);
    }

    /** @test */
    public function createJsonTypeColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->json('foo');

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` JSON NOT NULL", $sql);
    }

    /** @test */
    public function createEnumTypeColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->enum('foo', ['BAR', 'BAZ']);

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` ENUM('BAR','BAZ') NOT NULL", $sql);
    }

    /** @test */
    public function createEnumTypeColumnWithDefaultValueTest()
    {
        $structure = new Structure('test');

        $column = $structure->enum('foo', ['BAR', 'BAZ'])->default('BAR');

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` ENUM('BAR','BAZ') NOT NULL DEFAULT('BAR')", $sql);
    }

    /** @test */
    public function createPrimaryColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->number('foo')->primary();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` INT NOT NULL PRIMARY KEY", $sql);
    }

    /** @test */
    public function createNullableColumnHaveNullDefaultValueTest()
    {
        $structure = new Structure('test');

        $structure->number('foo')->nullable()->default(1);
        $structure->number('bar')->default(2)->nullable();

        $columns = $structure->done()[0];

        $sql = (new ColumnTranslateManager())->translate($columns);

        $this->assertSame("`foo` INT NULL , `bar` INT NULL", "{$sql[0]} , {$sql[1]}");
    }

    /** @test */
    public function createNullableIntTypeColumnAndUniqueStringTypeColumnTest()
    {
        $structure = new Structure('test');

        $structure->number('foo')->nullable();
        $structure->string('bar', 100)->unique();

        $columns = $structure->done()[0];

        $sql = (new ColumnTranslateManager())->translate($columns);

        $this->assertSame("`foo` INT NULL , `bar` VARCHAR(100) NOT NULL UNIQUE", "{$sql[0]} , {$sql[1]}");
    }

    /** @test */
    public function createCustomColumnsTest()
    {
        $structure = new Structure('test');

        $structure->boolean('foo')->default(1);
        $structure->double('bar')->nullable();

        $columns = $structure->done()[0];

        $sql = (new ColumnTranslateManager())->translate($columns);

        $this->assertSame("`foo` BOOLEAN NOT NULL DEFAULT('1') , `bar` DOUBLE NULL", "{$sql[0]} , {$sql[1]}");
    }

    /** @test */
    public function createForeignColumnTest()
    {
        $structure = new Structure('test');

        $structure->foreign('foo')->reference('id')->on('bar')->cascadeOnDelete();

        $columns = $structure->done()[0];

        $sql = (new ColumnTranslateManager("MySql"))->translate($columns)[0];

        $this->assertSame("FOREIGN KEY (foo) REFERENCES `bar`(id) ON DELETE CASCADE", $sql);
    }

    /** @test */
    public function createForeignIdColumnTest()
    {
        $structure = new Structure('test');

        $structure->id();
        $structure->foreignBarId()->reference('id')->on('bar')->cascadeOnUpdate();
        
        $columns = $structure->done()[0];

        $sql = (new ColumnTranslateManager("MySql"))->translate($columns);

        $this->assertSame("`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, FOREIGN KEY (bar_id) REFERENCES `bar`(id) ON UPDATE CASCADE", "{$sql[0]}, {$sql[1]}");
    }

    /** @test */
    public function createRelationTest()
    {
        $userStructure = new Structure('users');
        $userStructure->number('id')->primary()->autoIncrement();
        $usersColumn = $userStructure->done()[0];

        $postStructure = new Structure('posts');
        $postStructure->number('user_id');
        $postStructure->foreign('user_id')->reference('id')->on('users')->cascadeOnDelete();
        $postsColumn = $postStructure->done()[0];

        $userSql = (new ColumnTranslateManager("MySql"))->translate($usersColumn)[0];
        $postSql = (new ColumnTranslateManager("MySql"))->translate($postsColumn);

        $this->assertSame("`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY", $userSql);
        $this->assertSame("`user_id` INT NOT NULL, FOREIGN KEY (user_id) REFERENCES `users`(id) ON DELETE CASCADE", "{$postSql[0]}, {$postSql[1]}");
    }

    /** @test */
    public function createIndexedColumnTest()
    {
        $structure = new Structure('test');

        $column = $structure->string('foo')->index()->unique();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` VARCHAR(255) NOT NULL UNIQUE , INDEX(foo)", $sql);
    }
}

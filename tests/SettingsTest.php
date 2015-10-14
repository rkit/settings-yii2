<?php

/**
 * @link https://github.com/rkit/settings-yii2
 * @copyright Copyright (c) 2015 Igor Romanov
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace tests;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class SettingsTest extends \PHPUnit_Framework_TestCase
{
    public $data = [
        'email' => 'testEmail',
        'name' => 'testName',
        'number' => 3000,
    ];

    protected function setUp()
    {
        Yii::$app->settings->load($this->data);
    }

    protected function tearDown()
    {
        Yii::$app->settings->load([]);
    }

    public function testInit()
    {
        $rows = (new Query())->select('*')->from(Yii::$app->settings->tableName)->all();
        $rows = ArrayHelper::map($rows, 'key', 'value');

        $this->assertCount(3, Yii::$app->settings->all());
        $this->assertEquals($rows, Yii::$app->settings->all());

        // for test load from cache
        Yii::$app->settings->init();
    }

    public function testLoad()
    {
        Yii::$app->settings->load(['testKey' => 'testValue']);
        $this->assertCount(1, Yii::$app->settings->all());
        $this->assertEquals('testValue', Yii::$app->settings->get('testKey'));
    }

    public function testSet()
    {
        Yii::$app->settings->set('name', 'testName2');
        $this->assertEquals('testName2', Yii::$app->settings->get('name'));

        Yii::$app->settings->name = 'testName3';
        $this->assertEquals('testName3', Yii::$app->settings->get('name'));
    }

    public function testGet()
    {
        $this->assertEquals('testName', Yii::$app->settings->get('name'));
        $this->assertNull(Yii::$app->settings->get('name_wrong'));

        $this->assertEquals('testName', Yii::$app->settings->name);
        $this->assertNull(Yii::$app->settings->name_wrong);
    }

    public function testEmpty()
    {
        Yii::$app->settings->load([]);
        $this->assertCount(0, Yii::$app->settings->all());
    }

    public function testAdd()
    {
        Yii::$app->settings->set('addKey', 'addValue');
        $this->assertEquals('addValue', Yii::$app->settings->get('addKey'));

        Yii::$app->settings->addKey2 = 'addValue2';
        $this->assertEquals('addValue2', Yii::$app->settings->get('addKey2'));

        $this->assertCount(5, Yii::$app->settings->all());
    }
}

<?php

/**
 * @link https://github.com/rkit/settings-yii2
 * @copyright Copyright (c) 2015 Igor Romanov
 * @license [MIT](http://opensource.org/licenses/MIT)
 */

namespace tests;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class SettingsTest extends \PHPUnit_Framework_TestCase
{
    public $data = [
        'email' => 'test_email',
        'name' => 'test_name',
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
        Yii::$app->settings->load(['test_key' => 'test_value']);
        $this->assertCount(1, Yii::$app->settings->all());
        $this->assertEquals('test_value', Yii::$app->settings->get('test_key'));
    }

    public function testSetAndGet()
    {
        Yii::$app->settings->set('test_name', 'test_value');
        $this->assertEquals('test_value', Yii::$app->settings->get('test_name'));

        Yii::$app->settings->test_name = 'test_value';
        $this->assertEquals('test_value', Yii::$app->settings->test_name);

        Yii::$app->settings->set('test_name', '');
        $this->assertEquals('', Yii::$app->settings->get('test_name'));

        Yii::$app->settings->test_name = '';
        $this->assertEquals('', Yii::$app->settings->test_name);

        Yii::$app->settings->test_name = null;
        $this->assertEquals(null, Yii::$app->settings->test_name);

        $this->assertNull(Yii::$app->settings->non_exist);
        $this->assertNull(Yii::$app->settings->get('non_exist'));
    }

    public function testClear()
    {
        Yii::$app->settings->load([]);
        $this->assertCount(0, Yii::$app->settings->all());
    }
}

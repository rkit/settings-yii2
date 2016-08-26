<?php

/**
 * @link https://github.com/rkit/settings-yii2
 * @copyright Copyright (c) 2015 Igor Romanov
 * @license [MIT](http://opensource.org/licenses/MIT)
 */

namespace rkit\settings;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Query;

/**
 * Component for storage settings in db
 */
class Settings extends \yii\base\Component
{
    /**
     * @var string $tableName Table name
     */
    public $tableName = 'settings';
    /**
     * @var string $cacheName A key identifying the values to be cached
     */
    public $cacheName = 'settings';
    /**
     * @var string $cache Cache component name
     */
    public $cache = 'cache';
    /**
     * @var array $data
     */
    private $data = [];

    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function init()
    {
        parent::init();

        $data = Yii::$app->{$this->cache}->get($this->cacheName);

        if ($data) {
            $this->data = unserialize($data);
        } else {
            $data = (new Query())->select('*')->from($this->tableName)->all();
            $data = ArrayHelper::map($data, 'key', 'value');
            $this->updateData($data);
        }
    }

    /**
     * Get all data
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Get value by key
     *
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return ArrayHelper::getValue($this->data, $key, null);
    }

    /**
     * Set value
     *
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        if (array_key_exists($key, $this->data)) {
            $this->update($key, $value);
        } else {
            $this->add($key, $value);
        }

        $this->data[$key] = $value;
        $this->updateData($this->data);
    }

    /**
     * Add setting
     *
     * @param string $key
     * @param string $value
     */
    private function add($key, $value)
    {
        Yii::$app->db
            ->createCommand()
            ->insert($this->tableName, ['key' => $key, 'value' => $value])->execute();
    }

    /**
     * Update setting
     *
     * @param string $key
     * @param string $value
     */
    private function update($key, $value)
    {
        Yii::$app->db
            ->createCommand()
            ->update($this->tableName, ['value' => $value], '`key` = :key', [':key' => $key])->execute();
    }

    /**
     * Load data
     *
     * @param array $data
     */
    public function load($data)
    {
        $db = Yii::$app->db->createCommand();
        $db->truncateTable($this->tableName)->execute();

        if (is_array($data) && count($data)) {
            $db->batchInsert($this->tableName, ['key', 'value'], $this->prepareDataForInsert($data))->execute();
        }
        $this->updateData($data);
    }

    /**
     * Prepare data for insert
     *
     * @param array $data
     * @return array
     */
    private function prepareDataForInsert($data)
    {
        $items = [];
        foreach ($data as $key => $value) {
            $items[] = ['key' => $key, 'value' => $value];
        }

        return $items;
    }

    /**
     * Update data and cache
     *
     * @param array $data
     */
    private function updateData($data)
    {
        $this->data = $data;

        $cache = Yii::$app->{$this->cache};
        $cache->delete($this->cacheName);

        if (is_array($this->data) && count($this->data)) {
            $cache->set($this->cacheName, serialize($this->data));
        }
    }
}

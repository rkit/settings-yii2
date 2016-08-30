# Guide

## Configuration

Add the following in your config, in section `components`

```php
'settings' => [
      'class' => 'rkit\settings\Settings',
      'cache' => 'cache', // cache component name
      'tableName' => 'settings' // table name
      'cacheName' => 'settings' // a key identifying the values to be cached
 ]
```

## Usage

### Basic usage

1. Populates the settings
   ```php
   Yii::$app->settings->load(['key' => 'value']);
   ```

2. Set
   ```php
   Yii::$app->settings->set('key', 'value');
   // or
   Yii::$app->settings->key = value;
   ```

3. Get
   ```php
   Yii::$app->settings->get('key');
   // or
   Yii::$app->settings->key;
   // get all
   Yii::$app->settings->all();
   ```

### Example for editing in the control panel

1. Controller
   ```php
   $model = new Settings();

    if (Yii::$app->request->isPost) {
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             Yii::$app->settings->load($model->getAttributes());
             Yii::$app->session->setFlash('success', Yii::t('app', 'Saved successfully'));
             return $this->refresh();
         }
    }

    $model->setAttributes(Yii::$app->settings->all());

    return $this->render('index', ['model' => $model]);
   ```

2. Model
   ```php
   class Settings extends \yii\base\Model
   {
      …
      public function rules()
      {
          return [
              ['emailPrefix', 'trim'],
              ['emailMain', 'email'],
              …
          ];
      }
      …
   }
   ```

3. View
   ```php
   …
   <?= $form->field($model, 'emailMain') ?>
   <?= $form->field($model, 'emailPrefix') ?>
   …
   ```

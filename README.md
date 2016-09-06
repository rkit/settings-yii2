# Settings for Yii2

[![Build Status](https://travis-ci.org/rkit/settings-yii2.svg?branch=master)](https://travis-ci.org/rkit/settings-yii2)
[![Code Coverage](https://scrutinizer-ci.com/g/rkit/settings-yii2/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/rkit/settings-yii2/?branch=master)
[![codecov.io](http://codecov.io/github/rkit/settings-yii2/coverage.svg?branch=master)](http://codecov.io/github/rkit/settings-yii2?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rkit/settings-yii2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rkit/settings-yii2/?branch=master)

## Installation

1. Installing using Composer
   ```
   composer require rkit/settings-yii2
   ```

2. Run migrations
   ```
   php yii migrate --migrationPath=@vendor/rkit/settings-yii2/src/migrations/ --interactive=0
   ```

## Documentation

- [Guide](/guide)

## Development

### Tests

- [See docs](/tests/#tests)

### Coding Standard

- PHP Code Sniffer — [phpcs.xml](./phpcs.xml)
- PHP Mess Detector — [phpmd.xml](./phpmd.xml)

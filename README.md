Yii Highcharts Widget
========================

[![Latest Stable Version](https://poser.pugx.org/miloschuman/yii-highcharts/v/stable.png)](https://packagist.org/packages/miloschuman/yii-highcharts)
[![Total Downloads](https://poser.pugx.org/miloschuman/yii-highcharts/downloads.png)](https://packagist.org/packages/miloschuman/yii-highcharts)
[![License](https://poser.pugx.org/miloschuman/yii-highcharts/license.png)](https://packagist.org/packages/miloschuman/yii-highcharts)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/miloschuman/yii-highcharts/badges/quality-score.png?s=9a47e9e8f4f1c75e1ff36524ee75fc5ef65422bb)](https://scrutinizer-ci.com/g/miloschuman/yii-highcharts/)

Easily add [Highcharts, Highstock and Highmaps](http://www.highcharts.com/) graphs to your Yii application.

![Screen Shot](http://www.yiiframework.com/extension/highcharts/files/screenshot.png)


About
-----

### Highcharts ###
> Create interactive charts easily for your web projects. Used by tens of thousands of developers and 59 out of the world's 100 largest companies, Highcharts is the simplest yet most flexible charting API on the market.

### Highstock ###
> Highstock lets you create stock or general timeline charts in pure JavaScript. Including sophisticated navigation options like a small navigator series, preset date ranges, date picker, scrolling and panning.

### Highmaps ###
> Build interactive maps to display sales, election results or any other information linked to geography. Perfect for standalone use or in dashboards in combination with Highcharts!


Links
-----

* [Home page](https://github.com/miloschuman/yii-highcharts)
* [Highcharts demos](http://www.highcharts.com/demo/)
* [Report a bug](https://github.com/miloschuman/yii-highcharts/issues)
* [(**New**) Highcharts Extension for **Yii2**](http://www.yiiframework.com/extension/yii2-highcharts-widget)

**Note:** Highcharts is free for non-commercial use only. For more information, please visit the [Highcharts License and Pricing](http://www.highcharts.com/license) page.


Requirements
------------

* Yii 1.1.5 or above
* PHP 5.1 or above


Installation
-------------

* Extract the release file under `protected/extensions/`


Usage
-----

To use this widget, you may insert the following code into a view file:
```php
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
      'title' => array('text' => 'Fruit Consumption'),
      'xAxis' => array(
         'categories' => array('Apples', 'Bananas', 'Oranges')
      ),
      'yAxis' => array(
         'title' => array('text' => 'Fruit eaten')
      ),
      'series' => array(
         array('name' => 'Jane', 'data' => array(1, 0, 4)),
         array('name' => 'John', 'data' => array(5, 7, 3))
      )
   )
));
```
By configuring the `options` property, you may specify the options that need to be passed to the Highcharts JavaScript object. Please refer to the demo gallery and documentation on the [Highcharts website](http://www.highcharts.com/) for possible options.

Alternatively, you can use a valid JSON string in place of an associative array to specify options:
```php
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>'{
      "title": { "text": "Fruit Consumption" },
      "xAxis": {
         "categories": ["Apples", "Bananas", "Oranges"]
      },
      "yAxis": {
         "title": { "text": "Fruit eaten" }
      },
      "series": [
         { "name": "Jane", "data": [1, 0, 4] },
         { "name": "John", "data": [5, 7,3] }
      ]
   }'
));
```

*Note:* You must provide a *valid* JSON string (double quotes) when using the second option. You can quickly validate your JSON string online using [JSONLint](http://jsonlint.com/).

See [/doc/examples](https://github.com/miloschuman/yii-highcharts/tree/master/doc/examples) for more usage examples.


Tips
----

* If you need to use JavaScript in any of your configuration options, use the `js:` prefix. For instance:

  ```php
  ...
  'tooltip' => array(
       'formatter' => 'js:function(){ return this.series.name; }'
  ),
  ...
  ```
* Highcharts by default displays a small credits label in the lower right corner of the chart. This can be removed using the following top-level option.

  ```php
  ...
  'credits' => array('enabled' => false),
  ...
  ```
* Since version 3.0.2, all adapters, modules, themes, and supplementary chart types must be enabled through the top-level 'scripts' option.

  ```php
  ...
  'scripts' => array(
       'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
       'modules/exporting', // adds Exporting button/menu to chart
       'themes/grid'        // applies global 'grid' theme to all charts
  ),
  ...
  ```
  Previous versions relied on auto-detection magic, but that became less reliable as Highcharts evolved. The new method
  more accurately follows the native process of including/excluding additional script files and gives the user some finer-grain control.
  For a list of available scripts, see the contents of `protected/extensions/highcharts/assets/`.
* You can access the JavaScript chart object from another script like this:

  ```javascript
  var chart = $('#my-chart-id').highcharts();
  ```
  where `my-chart-id` is set via the top-level `id` configuration option. Just make sure you
  register your script after the widget declaration so that it has a chance to initialize.


Change Log
----------

### [v4.1.9](https://github.com/miloschuman/yii-highcharts/releases/tag/v4.1.9) (2015-10-12) ###
* Upgraded Highcharts core library to the latest release (4.1.9). See the Highcharts [changelog](http://highcharts.com/documentation/changelog) for more information about what's new in this version.

### [v4.1.8](https://github.com/miloschuman/yii-highcharts/releases/tag/v4.1.8) (2015-09-24) ###
* Upgraded Highcharts core library to the latest release (4.1.8).

### [v4.1.7](https://github.com/miloschuman/yii-highcharts/releases/tag/v4.1.7) (2015-07-09) ###
* Upgraded Highcharts core library to the latest release (4.1.7).
* Resolved [issue #12](https://github.com/miloschuman/yii-highcharts/issues/12) by introducing new 'scriptPosition' option.

### [v4.0.4](https://github.com/miloschuman/yii-highcharts/releases/tag/v4.0.4) (2014-09-19) ###
* Upgraded Highcharts core library to the latest release (4.0.4). 
* Added HighmapsWidget.
* Added usage examples in [/doc/examples](https://github.com/miloschuman/yii-highcharts/tree/master/doc/examples).
* Resolved [issue #8](https://github.com/miloschuman/yii-highcharts/issues/8): Using Highcharts and Highstock on the same page throws error 16

### [v4.0.1](https://github.com/miloschuman/yii-highcharts/releases/tag/v4.0.1) (2014-04-25) ###
* Upgraded Highcharts core library to the latest release (4.0.1).

### [v3.0.10](https://github.com/miloschuman/yii-highcharts/releases/tag/v3.0.10) (2014-03-17) ###
* Upgraded Highcharts core library to the latest release (3.0.10).
* Bugfix for active highcharts

### [v3.0.9](https://github.com/miloschuman/yii-highcharts/releases/tag/v3.0.9) (2014-02-17) ###
* Upgraded Highcharts core library to the latest release (3.0.9).
* Added Composer support.
* Added ActiveHighstockWidget. Please see class file for documentation.

### [v3.0.5](https://github.com/miloschuman/yii-highcharts/releases/tag/v3.0.5) (2013-09-23) ###
* Upgraded Highcharts core library to the latest release (3.0.5).
* Added support for Highstock library via HighstockWidget class.
* Resolved [issue #1](https://github.com/miloschuman/yii-highcharts/issues/1): Themes not applied when in debug mode.

### [v3.0.4](https://github.com/miloschuman/yii-highcharts/releases/tag/v3.0.4) (2013-08-02) ###
* Upgraded Highcharts core library to the latest release (3.0.4).

### [v3.0.2](https://github.com/miloschuman/yii-highcharts/releases/tag/v3.0.2) (2013-07-22) ###
* Upgraded Highcharts core library to the latest release (3.0.2).
* The top-level 'scripts' option was added (per [Meng's recommendation](http://www.yiiframework.com/extension/highcharts/#c13934)) to streamline the inclusion of Highcharts' expanding catalog of adapters, modules, themes, and extended chart types. See "Tips" section above.

### [v2.3.5](https://github.com/miloschuman/yii-highcharts/releases/tag/v2.3.5) (2013-02-17) ###
* Upgraded Highcharts core library to the latest release (2.3.5).
* Added support for supplementary chart types: gauge, arearange, areasplinerange,  and columnrange.
* Fix for [PHP Notice issue](http://www.yiiframework.com/extension/highcharts/#c6119) mentioned by nervlin.
* Changed release numbering scheme to match underlying library version.

### [v0.5](https://github.com/miloschuman/yii-highcharts/releases/tag/v0.5) (2011-12-24) ###
* Upgraded Highcharts core library to the latest release (2.1.9).
* Minor bug fix.

### [v0.4](https://github.com/miloschuman/yii-highcharts/releases/tag/v0.4) (2011-09-25) ###
* Upgraded Highcharts core library to the latest release (2.1.6).
* Added global theming support.

### [v0.3](https://github.com/miloschuman/yii-highcharts/releases/tag/v0.3) (2011-01-23) ###
* Added support for PHP versions < 5.3.
* Upgraded Highcharts core JS library to the latest release (2.1.2).

### [v0.2](https://github.com/miloschuman/yii-highcharts/releases/tag/v0.2) (2010-10-15) ###
* Added support for the Exporting module, which allows users to download images or PDF's of your charts. See documentation for more details.
* Fixed bug which prevented this widget from rendering in a different container.

### [v0.1](https://github.com/miloschuman/yii-highcharts/releases/tag/v0.1) (2010-10-07) ###
* Initial release.

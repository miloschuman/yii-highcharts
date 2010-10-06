<?php
/**
 * HighchartsWidget class file.
 *
 * @author Milo Schuman <miloschuman@gmail.com>
 * @link http://yii-highcharts.googlecode.com/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version 0.1
 */

/**
 * HighchartsWidget encapsulates the {@link http://www.highcharts.com/ Highcharts}
 * charting library's Chart object.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->Widget('ext.highcharts.HighchartsWidget', array(
 *    'options'=>array(
 *       'title' => array('text' => 'Fruit Consumption'),
 *       'xAxis' => array(
 *          'categories' => array('Apples', 'Bananas', 'Oranges')
 *       ),
 *       'yAxis' => array(
 *          'title' => array('text' => 'Fruit eaten')
 *       ),
 *       'series' => array(
 *          array('name' => 'Jane', 'data' => array(1, 0, 4)),
 *          array('name' => 'John', 'data' => array(5, 7, 3))
 *       )
 *    )
 * ));
 * </pre>
 *
 * By configuring the {@link options} property, you may specify the options
 * that need to be passed to the Highcharts JavaScript object. Please refer to
 * the demo gallery and documentation on the {@link http://www.highcharts.com/
 * Highcharts website} for possible options.
 * 
 * Alternatively, you can use a valid JSON string in place of an associative
 * array to specify options:
 *
 * <pre>
 * $this->Widget('ext.highcharts.HighchartsWidget', array(
 *    'options'=>'{
 *       "title": { "text": "Fruit Consumption" },
 *       "xAxis": {
 *          "categories": ["Apples", "Bananas", "Oranges"]
 *       },
 *       "yAxis": {
 *          "title": { "text": "Fruit eaten" }
 *       },
 *       "series": [
 *          { "name": "Jane", "data": [1, 0, 4] },
 *          { "name": "John", "data": [5, 7,3] }
 *       ]
 *    }'
 * ));
 * </pre>
 *
 * Note: You must provide a valid JSON string (e.g. double quotes) when using
 * the second option. You can quickly validate your JSON string online using
 * {@link http://jsonlint.com/ JSONLint}.
 */
class HighchartsWidget extends CWidget {

	public $options = array();
	public $htmlOptions = array();

	/**
	 * Initializes the widget.
	 * This method will publish and register necessary script files.
	 * If you override this method, make sure you call the parent implementation first.
	 */
	public function init() {
		// register scripts
		$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
		$baseUrl = Yii::app()->getAssetManager()->publish($basePath);
		$scriptFile = YII_DEBUG ? '/highcharts.src.js' : '/highcharts.js';
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($baseUrl . $scriptFile);

		parent::init();
	}

	/**
	 * Renders the widget.
	 */
	public function run() {
		$id = $this->getId();
		$this->htmlOptions['id'] = $id;

		echo CHtml::openTag('div', $this->htmlOptions);
		echo CHtml::closeTag('div');

		// check if options parameter is a json string
		if (is_string($this->options)) {
			if (!$this->options = CJSON::decode($this->options))
				throw new CException('The options parameter is not valid JSON.');
			// TODO translate exception message
		}

		// define container element via Highcharts 'renderTo' option
		if (!isset($this->options['chart']))
			$this->options['chart'] = array();
		$this->options['chart']['renderTo'] = $id;

		$jsOptions = CJavaScript::encode($this->options);
		Yii::app()->clientScript->registerScript(__CLASS__ . '#' . $id, "var chart = new Highcharts.Chart($jsOptions);");
	}
}
?>
<?php

/**
 * ActiveHighstockWidget class file.
 *
 * @author David Baker <github@acorncomputersolutions.com>
 * @link https://github.com/miloschuman/yii-highcharts/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version 3.0.6
 */

Yii::import('highcharts.HighstockWidget');

/**
 * Usage:
 *
$this->widget('highcharts.ActiveHighstockWidget', array(
    'options' => array(
        'title' => array('text' => 'Site Percentile'),
        'yAxis' => array(
            'title' => array('text' => 'Site Rank')
        ),
        'series' => array(
            array(
                'name'  => 'Site percentile',
                'data'  => 'SiteRank12',        // data column in the dataprovider
                'time'  => 'RankDate',          // time column in the dataprovider
                // 'timeType'  => 'date',
                // defaults to a mysql timestamp, other options are 'date' (run through strtotime()) or 'plain'
            ),
        ),
    ),
    'dataProvider' => $dataProvider,
));
 *
 * @see HighchartsWidget for additional options
 */
class ActiveHighstockWidget extends HighstockWidget
{
    /**
     * Pass in a data provider that we will turn into the series
     * @var CDataProvider
     */
    public $dataProvider;

    public function run()
    {
        $data = $this->dataProvider->getData();
        $series = $this->options['series'];

        if(count($data) > 0) {
            foreach ($series as $i => $batch) {
                if (isset($batch['time']) && isset($batch['data']) &&
                    !is_array($batch['time']) && !is_array($batch['data'])
                ) {
                    $dateSeries = array();
                    foreach ($data as $row) {
                        $dateSeries[] = $this->processRow($row, $batch);
                    }

                    // we'll work on the actual item, this may be PHP 5.3+ specific
                    $this->sortDateSeries($dateSeries);

                    // clean up our time item so we don't accidentally conflict with Highstock
                    unset($this->options['series'][$i]['time']);

                    // and then reset our data column with our data series
                    $this->options['series'][$i]['data'] = $dateSeries;
                }
            }
        }

        parent::run();
    }

    /**
     * Handles processing a row and readying it for Highstock
     *
     * @param $row
     * @param $batch
     * @return array
     */
    protected function processRow($row, $batch) {
        // if we're dealing with a javascript timestamp
        // then just setup our array
        $timeType = (isset($batch['timeType'])) ? $batch['timeType'] : 'mysql';

        switch ($timeType) {
            case 'plain':
                return $this->processPlainTimestamp($row, $batch);
            case 'date':
                return $this->processDate($row, $batch);
            case 'mysql':
                return $this->processMysql($row, $batch);
            default:
                $functionName = 'process' . ucfirst($timeType);
                if(method_exists($this, $functionName)) {
                    return call_user_func(array($this, $functionName), $row, $batch);
                } else {
                    throw new Exception("Can't call your custom date processing function");
                }
        }
    }

    /**
     * Using this means your time needs to be in JS milliseconds
     *
     * @param $row
     * @param $batch
     * @return array
     */
    protected function processPlainTimestamp($row, $batch) {
        return array(
            floatval($row[$batch['time']]),
            $row[$batch['data']]
        );
    }

    /**
     * Converts dates using strtotime() to a MySQL timestamp and then changes to JS milliseconds
     *
     * @param $row
     * @param $batch
     * @return array
     */
    protected function processDate($row, $batch) {
        return array(
            1000 * floatval(strtotime($row[$batch['time']])),
            floatval($row[$batch['data']])
        );
    }

    /**
     * Converts a SQL unix timestamp to a JS timestamp (in milliseconds)
     * This is our default time processor if not specified
     *
     * @param $row
     * @param $batch
     * @return array
     */
    protected function processMysql($row, $batch) {
        return array(
            1000 * floatval($row[$batch['time']]),
            floatval($row[$batch['data']])
        );
    }

    /**
     * Sorts our date series so we have all the dates from first to last
     * @param $series
     */
    protected function sortDateSeries(&$series) {

        //sort by first column (dates ascending order)
        foreach ($series as $key => $row) {
            $dates[$key] = $row[0];
        }
        array_multisort($dates, SORT_ASC, $series);
    }
}
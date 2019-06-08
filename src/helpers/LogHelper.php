<?php
/**
 * Medium.com Meta Tag Parser for Feed Me
 *
 * Add meta tags to Medium.com feeds - Feed Me plugin
 *
 * @link      https://www.wbmngr.agency
 * @copyright Copyright (c) 2019 Ottó Radics
 */

namespace webmenedzser\mediumcommetatagparserforfeedme\helpers;

use webmenedzser\mediumcommetatagparserforfeedme\MediumComMetaTagParserForFeedMe;

use Craft;
use craft\base\Component;
use craft\helpers;

/**
 * @author    Ottó Radics
 * @package   MediumComMetaTagParserForFeedMe
 * @since     1.0.0
 */
class LogHelper extends Component
{
    /**
     * @param $message
     * @throws \yii\base\ErrorException
     */
    public static function writeLogs($message) {
        $file = Craft::getAlias('@storage/logs/parser.log');
        $log = date('Y-m-d H:i:s').' ' . $message."\n";

        helpers\FileHelper::writeToFile($file, $log, ['append' => true]);
    }
}

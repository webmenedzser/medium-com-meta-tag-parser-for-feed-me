<?php
/**
 * Feed Me - Medium.com meta tag parser plugin for Craft CMS 3.x
 *
 * Add meta tags to Medium.com feeds - Feed Me plugin
 *
 * @link      https://www.wbmngr.agency
 * @copyright Copyright (c) 2019 Ottó Radics
 */

namespace webmenedzser\feedmemediumcommetatagparser\helpers;

use webmenedzser\feedmemediumcommetatagparser\FeedMeMediumcomMetaTagParser;

use Craft;
use craft\base\Component;
use craft\helpers;

/**
 * @author    Ottó Radics
 * @package   FeedMeMediumcomMetaTagParser
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

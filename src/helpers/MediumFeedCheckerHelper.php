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

/**
 * @author    Ottó Radics
 * @package   MediumComMetaTagParserForFeedMe
 * @since     1.0.0
 */
class MediumFeedCheckerHelper extends Component
{
    /**
     * @param $feedUrl
     * @return bool
     */
    public static function isMediumFeed($data) {
        if (strpos($data, 'CDATA[yourfriends@medium.com]')) {
            return true;
        }

        return false;
    }
}

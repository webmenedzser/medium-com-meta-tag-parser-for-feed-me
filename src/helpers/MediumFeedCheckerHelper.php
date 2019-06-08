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

/**
 * @author    Ottó Radics
 * @package   FeedMeMediumcomMetaTagParser
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

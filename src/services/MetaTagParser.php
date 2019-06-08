<?php
/**
 * Feed Me - Medium.com meta tag parser plugin for Craft CMS 3.x
 *
 * Add meta tags to Medium.com feeds - Feed Me plugin
 *
 * @link      https://www.wbmngr.agency
 * @copyright Copyright (c) 2019 Ottó Radics
 */

namespace webmenedzser\feedmemediumcommetatagparser\services;

use webmenedzser\feedmemediumcommetatagparser\FeedMeMediumcomMetaTagParseruse;
use webmenedzser\feedmemediumcommetatagparser\helpers\UrlHelper;

use Craft;
use craft\base\Component;

class MetaTagParser extends Component
{
    public static function collectMetaTagsFromUrls($urls) {
        $data = [];

        foreach ($urls as $url) {
            $data[] = UrlHelper::getUrlData($url);
        }

        return $data;
    }
}

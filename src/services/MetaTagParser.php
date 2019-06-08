<?php
/**
 * Medium.com Meta Tag Parser for Feed Me
 *
 * Add meta tags to Medium.com feeds - Feed Me plugin
 *
 * @link      https://www.wbmngr.agency
 * @copyright Copyright (c) 2019 Ottó Radics
 */

namespace webmenedzser\mediumcommetatagparserforfeedme\services;

use webmenedzser\mediumcommetatagparserforfeedme\MediumComMetaTagParserForFeedMe;
use webmenedzser\mediumcommetatagparserforfeedme\helpers\UrlHelper;

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

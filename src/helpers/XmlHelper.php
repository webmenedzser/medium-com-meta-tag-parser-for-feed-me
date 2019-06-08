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

use webmenedzser\feedmemediumcommetatagparser\FeedMeMediumComMetaTagParser;

use Craft;
use craft\base\Component;
use craft\helpers;

/**
 * @author    Ottó Radics
 * @package   FeedMeMediumComMetaTagParser
 * @since     1.0.0
 */
class XmlHelper extends Component
{
    public static function findItems($data) {
        $xmlDoc = new \DOMDocument();
        $xmlDoc->loadXML($data);
        $items = $xmlDoc->getElementsByTagName('item');

        return $items;
    }

    public static function findUrls($data) {
        $items = XmlHelper::findItems($data);

        foreach ($items as $item) {
            $urls[] = $item->getElementsByTagName('link')->item(0)->nodeValue;
        }

        return $urls;
    }
}

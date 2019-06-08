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

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
class UrlHelper extends Component
{
    // Based on mariano at cricava dot com's work
    // Source: https://www.php.net/manual/en/function.get-meta-tags.php
    // Heavily refactored with 1.0.5
    public static function getUrlData($url)
    {
        $result = false;

        $contents = UrlHelper::getUrlContents($url);

        if (isset($contents) && is_string($contents))
        {
            $metaTags = null;
            $metaProperties = null;

            preg_match_all(
                '/(.*?(name|property)="(.*?)").*?(content|value)="(.*?)"/',
                $contents,
                $match
            );

            $names = $match[3];
            $values = $match[5];

            $result = array_combine($names, $values);
        }

        return $result;
    }

    public static function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
    {
        $result = false;

        $contents = @file_get_contents($url);

        // Check if we need to go somewhere else

        if (isset($contents) && is_string($contents))
        {
            preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);

            if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
            {
                if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
                {
                    return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
                }

                $result = false;
            }
            else
            {
                $result = $contents;
            }
        }

        return $contents;
    }
}

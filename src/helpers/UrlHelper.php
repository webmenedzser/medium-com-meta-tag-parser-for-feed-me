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
class UrlHelper extends Component
{
    // Based on mariano at cricava dot com's work
    // Source: https://www.php.net/manual/en/function.get-meta-tags.php
    public static function getUrlData($url)
    {
        $result = false;

        $contents = UrlHelper::getUrlContents($url);

        if (isset($contents) && is_string($contents))
        {
            $title = null;
            $metaTags = null;
            $metaProperties = null;

            preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );

            if (isset($match) && is_array($match) && count($match) > 0)
            {
                $title = strip_tags($match[1]);
            }

            preg_match_all('/<[\s]*meta[\s]*(name|property)="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);

            if (isset($match) && is_array($match) && count($match) == 4)
            {
                $originals = $match[0];
                $names = $match[2];
                $values = $match[3];

                if (count($originals) == count($names) && count($names) == count($values))
                {
                    $metaTags = array();
                    $metaProperties = $metaTags;

                    for ($i=0, $limiti=count($names); $i < $limiti; $i++)
                    {
                        if ($match[1][$i] == 'name')
                            $meta_type = 'metaTags';
                        else
                            $meta_type = 'metaProperties';

                        ${$meta_type}[$names[$i]] = $values[$i];
                    }
                }
            }

            $result = array_merge($metaTags, $metaProperties);
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

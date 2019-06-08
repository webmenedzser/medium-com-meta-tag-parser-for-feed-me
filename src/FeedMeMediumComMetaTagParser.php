<?php
/**
 * Feed Me - Medium.com meta tag parser plugin for Craft CMS 3.x
 *
 * Add meta tags to Medium.com feeds - Feed Me plugin
 *
 * @link      https://www.wbmngr.agency
 * @copyright Copyright (c) 2019 Ottó Radics
 */

namespace webmenedzser\feedmemediumcommetatagparser;

use nystudio107\seomatic\models\MetaTag;
use webmenedzser\feedmemediumcommetatagparser\helpers\MediumFeedCheckerHelper as MediumFeedCheckerHelper;
use webmenedzser\feedmemediumcommetatagparser\helpers\UrlHelper as UrlHelper;
use webmenedzser\feedmemediumcommetatagparser\helpers\XmlHelper as XmlHelper;
use webmenedzser\feedmemediumcommetatagparser\services\MetaTagParser as MetaTagParser;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\feedme\events\FeedDataEvent;
use craft\feedme\services\DataTypes;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Ottó Radics
 * @package   FeedMeMediumcomMetaTagParser
 * @since     1.0.0
 */
class FeedMeMediumcomMetaTagParser extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * FeedMeMediumcomMetaTagParser::$plugin
     *
     * @var FeedMeMediumcomMetaTagParser
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /*
     * Collect article URLs into this array.
     *
     * @var array
     */
    public $urls = [];

    /*
     * Collect meta tags into this array.
     *
     * @var array
     */
    public $data = [];

    /*
     * Collect feed items into this array.
     *
     * @var array
     */
    public $items = [];

    /*
     * Count the items in the feed
     *
     * @var int
     */
    public $count = 0;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * FeedMeMediumMetaTagParser::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(DataTypes::class, DataTypes::EVENT_AFTER_FETCH_FEED, function(FeedDataEvent $event) {
            if ($event->response['success']) {
                $this->_processFeed($event);
            }
        });

        Event::on(DataTypes::class, DataTypes::EVENT_AFTER_PARSE_FEED, function(FeedDataEvent $event) {
            if ($event->response['success']) {
                $this->_enhanceFeed($event);
            }
        });
    }

    // Private Methods
    // =========================================================================

    private function _processFeed($event) {
        $data = $event->response['data'];
        $mediumFeed = MediumFeedCheckerHelper::isMediumFeed($event->response['data']);

        if ($mediumFeed) {
            $this->items = XmlHelper::findItems($data);
            $this->count = count($this->items);
            $this->urls = XmlHelper::findUrls($data);

            $metaTags = MetaTagParser::collectMetaTagsFromUrls($this->urls);
            foreach ($metaTags as $key => $value) {
                $this->data[] = $value;
            }
        }
    }

    private function _enhanceFeed($event) {
        for ($i = 0; $i < $this->count; $i++) {
            foreach ($this->data[$i] as $key => $value) {
                $event->response['data'][$i][$key] = $value;
            }
        }
    }
}

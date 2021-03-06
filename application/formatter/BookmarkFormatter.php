<?php

namespace Shaarli\Formatter;

use DateTime;
use Shaarli\Config\ConfigManager;
use Shaarli\Bookmark\Bookmark;

/**
 * Class BookmarkFormatter
 *
 * Abstract class processing all bookmark attributes through methods designed to be overridden.
 *
 * @package Shaarli\Formatter
 */
abstract class BookmarkFormatter
{
    /**
     * @var ConfigManager
     */
    protected $conf;

    /**
     * @var array Additional parameters than can be used for specific formatting
     *            e.g. index_url for Feed formatting
     */
    protected $contextData = [];

    /**
     * LinkDefaultFormatter constructor.
     * @param ConfigManager $conf
     */
    public function __construct(ConfigManager $conf)
    {
        $this->conf = $conf;
    }

    /**
     * Convert a Bookmark into an array usable by templates and plugins.
     *
     * All Bookmark attributes are formatted through a format method
     * that can be overridden in a formatter extending this class.
     *
     * @param Bookmark $bookmark instance
     *
     * @return array formatted representation of a Bookmark
     */
    public function format($bookmark)
    {
        $out['id'] = $this->formatId($bookmark);
        $out['shorturl'] = $this->formatShortUrl($bookmark);
        $out['url'] = $this->formatUrl($bookmark);
        $out['real_url'] = $this->formatRealUrl($bookmark);
        $out['title'] = $this->formatTitle($bookmark);
        $out['description'] = $this->formatDescription($bookmark);
        $out['thumbnail'] = $this->formatThumbnail($bookmark);
        $out['taglist'] = $this->formatTagList($bookmark);
        $out['tags'] = $this->formatTagString($bookmark);
        $out['sticky'] = $bookmark->isSticky();
        $out['private'] = $bookmark->isPrivate();
        $out['class'] = $this->formatClass($bookmark);
        $out['created'] = $this->formatCreated($bookmark);
        $out['updated'] = $this->formatUpdated($bookmark);
        $out['timestamp'] = $this->formatCreatedTimestamp($bookmark);
        $out['updated_timestamp'] = $this->formatUpdatedTimestamp($bookmark);
        return $out;
    }

    /**
     * Add additional data available to formatters.
     * This is used for example to add `index_url` in description's links.
     *
     * @param string $key   Context data key
     * @param string $value Context data value
     */
    public function addContextData($key, $value)
    {
        $this->contextData[$key] = $value;
    }

    /**
     * Format ID
     *
     * @param Bookmark $bookmark instance
     *
     * @return int formatted ID
     */
    protected function formatId($bookmark)
    {
        return $bookmark->getId();
    }

    /**
     * Format ShortUrl
     *
     * @param Bookmark $bookmark instance
     *
     * @return string formatted ShortUrl
     */
    protected function formatShortUrl($bookmark)
    {
        return $bookmark->getShortUrl();
    }

    /**
     * Format Url
     *
     * @param Bookmark $bookmark instance
     *
     * @return string formatted Url
     */
    protected function formatUrl($bookmark)
    {
        return $bookmark->getUrl();
    }

    /**
     * Format RealUrl
     * Legacy: identical to Url
     *
     * @param Bookmark $bookmark instance
     *
     * @return string formatted RealUrl
     */
    protected function formatRealUrl($bookmark)
    {
        return $bookmark->getUrl();
    }

    /**
     * Format Title
     *
     * @param Bookmark $bookmark instance
     *
     * @return string formatted Title
     */
    protected function formatTitle($bookmark)
    {
        return $bookmark->getTitle();
    }

    /**
     * Format Description
     *
     * @param Bookmark $bookmark instance
     *
     * @return string formatted Description
     */
    protected function formatDescription($bookmark)
    {
        return $bookmark->getDescription();
    }

    /**
     * Format Thumbnail
     *
     * @param Bookmark $bookmark instance
     *
     * @return string formatted Thumbnail
     */
    protected function formatThumbnail($bookmark)
    {
        return $bookmark->getThumbnail();
    }

    /**
     * Format Tags
     *
     * @param Bookmark $bookmark instance
     *
     * @return array formatted Tags
     */
    protected function formatTagList($bookmark)
    {
        return $bookmark->getTags();
    }

    /**
     * Format TagString
     *
     * @param Bookmark $bookmark instance
     *
     * @return string formatted TagString
     */
    protected function formatTagString($bookmark)
    {
        return implode(' ', $bookmark->getTags());
    }

    /**
     * Format Class
     * Used to add specific CSS class for a link
     *
     * @param Bookmark $bookmark instance
     *
     * @return string formatted Class
     */
    protected function formatClass($bookmark)
    {
        return $bookmark->isPrivate() ? 'private' : '';
    }

    /**
     * Format Created
     *
     * @param Bookmark $bookmark instance
     *
     * @return DateTime instance
     */
    protected function formatCreated(Bookmark $bookmark)
    {
        return $bookmark->getCreated();
    }

    /**
     * Format Updated
     *
     * @param Bookmark $bookmark instance
     *
     * @return DateTime instance
     */
    protected function formatUpdated(Bookmark $bookmark)
    {
        return $bookmark->getUpdated();
    }

    /**
     * Format CreatedTimestamp
     *
     * @param Bookmark $bookmark instance
     *
     * @return int formatted CreatedTimestamp
     */
    protected function formatCreatedTimestamp(Bookmark $bookmark)
    {
        if (! empty($bookmark->getCreated())) {
            return $bookmark->getCreated()->getTimestamp();
        }
        return 0;
    }

    /**
     * Format UpdatedTimestamp
     *
     * @param Bookmark $bookmark instance
     *
     * @return int formatted UpdatedTimestamp
     */
    protected function formatUpdatedTimestamp(Bookmark $bookmark)
    {
        if (! empty($bookmark->getUpdated())) {
            return $bookmark->getUpdated()->getTimestamp();
        }
        return 0;
    }
}

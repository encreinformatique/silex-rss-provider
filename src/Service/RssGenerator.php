<?php

namespace EncreInformatique\SilexRssProvider\Service;

class RssGenerator
{
    /**
     * @var \XMLWriter
     */
    protected $sitemap;

    /**
     * @var array xmlns
     */
    protected $xmlns = array(
            'atom' => 'http://www.w3.org/2005/Atom',
            'content' => 'http://purl.org/rss/1.0/modules/content/',
            'dc' => 'http://purl.org/dc/elements/1.1/',
            'sy' => 'http://purl.org/rss/1.0/modules/syndication/'
        );

    /**
     * @param \XMLWriter $xmlWriter
     * @param string     $version
     * @param string     $charset
     */
    public function __construct(\XMLWriter $xmlWriter, $version = '1.0', $charset = 'utf-8')
    {
        $this->sitemap = $xmlWriter;
        $this->sitemap->openMemory();

        $this->sitemap->startDocument($version, $charset);
        $this->sitemap->setIndent(true);

        $this->sitemap->startElement('rss');
        $this->sitemap->writeAttribute('version', '2.0');
        $this->sitemap->writeAttribute('xmlns:content', $this->xmlns['content']);
        $this->sitemap->writeAttribute('xmlns:dc', $this->xmlns['dc']);
        $this->sitemap->writeAttribute('xmlns:atom', $this->xmlns['atom']);
        $this->sitemap->writeAttribute('xmlns:sy', $this->xmlns['sy']);

        $this->sitemap->startElement('channel');
    }

    /**
     * @param string    $url
     * @param string    $title
     * @param string    $description
     *
     * @return RssGenerator
     */
    public function addChannelValues($url, $title, $description, $language)
    {
        /*
         * Mandatory Elements of the Channel.
         */
        $this->sitemap->writeElement('title', $title);
        $this->sitemap->writeElement('description', $description);
        $this->sitemap->writeElement('link', $url);
        $this->sitemap->writeElement('language', $language);

        $this->sitemap->startElement('atom:link');
        $this->sitemap->writeAttribute('href', $url);
        $this->sitemap->writeAttribute('rel', 'self');
        $this->sitemap->writeAttribute('type', 'application/rss+xml');
        $this->sitemap->endElement();

        return $this;
    }

    /**
     * @param string    $url
     * @param string    $title
     * @param \DateTime $pubDate
     * @return RssGenerator
     */
    public function addEntry($url, $title, \DateTime $pubDate = null)
    {
        $this->sitemap->startElement('item');

        $this->sitemap->writeElement('title', $title);
        $this->sitemap->writeElement('link', $url);
        $this->sitemap->writeElement('guid', $url);

        if ($pubDate instanceof \DateTime) {
            $this->sitemap->writeElement('pubDate', $pubDate->format(\DateTime::RFC822));
        }

        $this->sitemap->endElement();

        return $this;
    }

    /**
     * @param bool $doFlush
     *
     * @return string
     */
    public function generate($doFlush = true)
    {
        $this->sitemap->endElement();
        $this->sitemap->endElement();
        $this->sitemap->endDocument();

        return $this->sitemap->outputMemory($doFlush);
    }
}

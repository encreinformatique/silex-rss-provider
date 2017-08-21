<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Silex\Application;
use EncreInformatique\SilexRssProvider\RssProvider;
use Assert\Assertion;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Silex\Application
     */
    private $app;

    /**
     * @Given Service with charset :charset and version :version is available
     */
    public function isServiceAvailable($charset, $version)
    {
        $this->app = $this->generateApplication($charset, $version);

        Assertion::keyIsset($this->app, 'rss');
    }

    /**
     * @Given No entry was set
     */
    public function noEntryExists()
    {
        $rss = $this->app['rss']->generate(false);

        Assertion::eq(0, preg_match('/\<url\>/', $rss));
    }

    /**
     * @Then It should pass with:
     *
     * @param PyStringNode $string
     */
    public function isExpectedRssFeed(PyStringNode $string)
    {
        $rss = $this->app['rss']->generate(false);

        Assertion::eq(
            preg_replace('/(\s\s+|\t|\n)/', '', $string->getRaw()),
            preg_replace('/(\s\s+|\t|\n)/', '', $rss)
        );
    }

    /**
     * @param string $url
     * @param string $name
     * @param mixed  $value
     *
     * @When I add an entry :url with parameter :name and value :value
     */
    public function addEntry($url, $name = null, $value = null)
    {
        switch ($name)
        {
            case 'pubDate':
                $datetime = new \DateTime($value);
                $this->app['rss']->addEntry($url, 1.0, 'yearly', $datetime);
                break;

            default:
                $this->app['rss']->addEntry($url);
        }
    }

    /**
     * @param string $charset
     * @param string $version
     */
    private function generateApplication($charset, $version)
    {
        $options = [
            'debug' => true,
            'rss.options' => [
                'charset' => $charset,
                'version' => $version
            ]
        ];

        $app = new Application($options);
        $app->register(new RssProvider);

        return $app;
    }
}

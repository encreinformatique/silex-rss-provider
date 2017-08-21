<?php

namespace EncreInformatique\SilexRssProvider\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use EncreInformatique\SilexRssProvider\Service\RssGenerator;

class RssProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $options = [
            'xml_writer' => new \XMLWriter,
            'version' => '1.0',
            'charset' => 'utf-8'
        ];

        if (isset($app['rss.options']) && is_array($app['rss.options'])) {
            $options = array_merge($options, $app['rss.options']);
        }

        $app['rss'] = function () use ($options) {
            return new RssGenerator(
                $options['xml_writer'], $options['version'], $options['charset']
            );
        };
    }
}

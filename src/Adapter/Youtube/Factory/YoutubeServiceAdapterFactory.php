<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 29/08/2015
 * Time: 19:24.
 */
namespace Coalmarch\Adapter\Youtube\Factory;

use Coalmarch\Adapter\CallableServiceAdapterFactoryInterface;
use Coalmarch\Adapter\Youtube\YoutubeServiceAdapter;
use Coalmarch\Renderer\EmbedRendererInterface;

class YoutubeServiceAdapterFactory implements CallableServiceAdapterFactoryInterface
{
    /**
     * @param string $url
     * @param string $pattern
     *
     * @return YoutubeServiceAdapter
     */
    public function __invoke($url, $pattern, EmbedRendererInterface $renderer)
    {
        $adapter = new YoutubeServiceAdapter($url, $pattern, $renderer);

        return $adapter;
    }
}

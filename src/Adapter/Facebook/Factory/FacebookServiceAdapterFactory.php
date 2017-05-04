<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 02/09/2015
 * Time: 22:41.
 */
namespace Coalmarch\Adapter\Facebook\Factory;

use Coalmarch\Adapter\Facebook\FacebookServiceAdapter;
use Coalmarch\Adapter\CallableServiceAdapterFactoryInterface;
use Coalmarch\Adapter\VideoAdapterInterface;
use Coalmarch\Renderer\EmbedRendererInterface;

class FacebookServiceAdapterFactory implements CallableServiceAdapterFactoryInterface
{
    /**
     * @param string                 $url
     * @param string                 $pattern
     * @param EmbedRendererInterface $renderer
     *
     * @return VideoAdapterInterface
     */
    public function __invoke($url, $pattern, EmbedRendererInterface $renderer)
    {
        return new FacebookServiceAdapter($url, $pattern, $renderer);
    }
}

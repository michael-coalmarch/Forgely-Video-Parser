<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 02/09/2015
 * Time: 22:41.
 */
namespace MichaelQuattrochi\Adapter\Facebook\Factory;

use MichaelQuattrochi\Adapter\Facebook\FacebookServiceAdapter;
use MichaelQuattrochi\Adapter\CallableServiceAdapterFactoryInterface;
use MichaelQuattrochi\Adapter\VideoAdapterInterface;
use MichaelQuattrochi\Renderer\EmbedRendererInterface;

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

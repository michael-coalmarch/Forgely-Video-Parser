<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 29/08/2015
 * Time: 14:56.
 */
namespace MichaelQuattrochi\Adapter\Vimeo\Factory;

use MichaelQuattrochi\Adapter\CallableServiceAdapterFactoryInterface;
use MichaelQuattrochi\Adapter\Vimeo\VimeoServiceAdapter;
use MichaelQuattrochi\Renderer\EmbedRendererInterface;

class VimeoServiceAdapterFactory implements CallableServiceAdapterFactoryInterface
{
    /**
     * @param string                 $url
     * @param string                 $pattern
     * @param EmbedRendererInterface $renderer
     *
     * @return VimeoServiceAdapter
     *
     * @internal param EmbedRendererInterface $rendererInterface
     */
    public function __invoke($url, $pattern, EmbedRendererInterface $renderer)
    {
        $adapter = new VimeoServiceAdapter($url, $pattern, $renderer);

        return $adapter;
    }
}

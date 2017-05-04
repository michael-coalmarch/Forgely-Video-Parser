<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 30/08/2015
 * Time: 14:40.
 */
namespace MichaelQuattrochi\Adapter\Dailymotion\Factory;

use MichaelQuattrochi\Adapter\Dailymotion\DailymotionServiceAdapter;
use MichaelQuattrochi\Adapter\CallableServiceAdapterFactoryInterface;
use MichaelQuattrochi\Adapter\VideoAdapterInterface;
use MichaelQuattrochi\Renderer\EmbedRendererInterface;

class DailymotionServiceAdapterFactory implements CallableServiceAdapterFactoryInterface
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
        $dailyMotionServiceAdapter = new DailymotionServiceAdapter($url, $pattern, $renderer);

        return $dailyMotionServiceAdapter;
    }
}

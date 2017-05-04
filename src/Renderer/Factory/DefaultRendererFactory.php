<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 30/08/2015
 * Time: 01:05.
 */
namespace MichaelQuattrochi\Renderer\Factory;

use MichaelQuattrochi\Renderer\DefaultRenderer;
use MichaelQuattrochi\Renderer\EmbedRendererInterface;

class DefaultRendererFactory implements RendererFactoryInterface
{
    /**
     * @return EmbedRendererInterface
     */
    public function __invoke()
    {
        $renderer = new DefaultRenderer();

        return $renderer;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 30/08/2015
 * Time: 01:09.
 */
namespace MichaelQuattrochi\Renderer\Factory;

use MichaelQuattrochi\Renderer\EmbedRendererInterface;

interface RendererFactoryInterface
{
    /**
     * @return EmbedRendererInterface
     */
    public function __invoke();
}

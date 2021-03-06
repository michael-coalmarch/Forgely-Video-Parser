<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 10/02/2016
 * Time: 16:10
 */

namespace Coalmarch\Test\Adapter;


use PHPUnit_Framework_TestCase;
use Coalmarch\Adapter\Youtube\YoutubeServiceAdapter;
use Coalmarch\Matcher\VideoServiceMatcher;
use Coalmarch\Exception\ServiceNotAvailableException;

class YoutubeServiceAdapterTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider exampleUrlDataProvider
     * @param string $url
     */
    public function testServiceNameIsString($url)
    {
        $youtubeVideo = $this->getMockingObject($url);
        $this->assertInternalType('string', $youtubeVideo->getServiceName());
    }

    /**
     * @dataProvider exampleUrlDataProvider
     * @param string $url
     */
    public function testHasThumbnailIsBoolean($url)
    {
        $youtubeVideo = $this->getMockingObject($url);
        $this->assertInternalType('bool', $youtubeVideo->hasThumbnail());
    }

    /**
     * @dataProvider exampleUrlDataProvider
     * @param string $url
     */
    public function testGetThumbnailSizesIsArray($url)
    {
        $youtubeVideo = $this->getMockingObject($url);
        $this->assertInternalType('array', $youtubeVideo->getThumbNailSizes());
    }

    /**
     * @dataProvider exampleUrlDataProvider
     * @param string $url
     */
    public function testIfGetThumbnailIsString($url)
    {
        $youtubeVideo = $this->getMockingObject($url);
        $this->assertInternalType('string', $youtubeVideo->getSmallThumbnail());
        $this->assertInternalType('string', $youtubeVideo->getMediumThumbnail());
        $this->assertInternalType('string', $youtubeVideo->getLargeThumbnail());
        $this->assertInternalType('string', $youtubeVideo->getLargestThumbnail());
    }

    /**
     * @dataProvider exampleUrlDataProvider
     * @param string $url
     */
    public function testThrowsExceptionOnRequestThumbnailWithAnInvalidSize($url)
    {
        $youtubeVideo = $this->getMockingObject($url);
        $this->setExpectedException('\\Coalmarch\\Exception\\InvalidThumbnailSizeException');
        $youtubeVideo->getThumbnail('This Size does not exists :)');
    }

    /**
     * @dataProvider exampleUrlDataProvider
     * @param string $url
     */
    public function testIfEmbedUrlIsString($url)
    {
        $youtubeVideo = $this->getMockingObject($url);
        $this->assertInternalType('string', $youtubeVideo->getEmbedUrl());
    }

    /**
     * @dataProvider exampleUrlDataProvider
     * @param string $url
     */
    public function testIfGetEmbedUrlUsesRightScheme($url)
    {
        $videoObject = $this->getMockingObject($url);
        $embedUrl = $videoObject->getEmbedUrl(false, true);
        $this->assertContains('https', $embedUrl);

        $embedUrl = $videoObject->getEmbedUrl(false, false);
        $this->assertNotContains('https', $embedUrl);
    }

    /**
     * @dataProvider exampleUrlDataProvider
     * @param string $url
     */
    public function testIfIsEmbeddable($url)
    {
        $facebookVideo = $this->getMockingObject($url);
        $this->assertTrue($facebookVideo->isEmbeddable());
    }

    /**
     * @return array
     */
    public function exampleUrlDataProvider()
    {
        return array(
            array(
                'https://www.youtube.com/watch?v=uarCDXc3BjU',
                'https://youtu.be/uarCDXc3BjU',
                '<iframe width="560" height="315" src="https://www.youtube.com/embed/uarCDXc3BjU" frameborder="0" allowfullscreen></iframe>',
            ),
        );
    }

    /**
     * @param $url
     * @return YoutubeServiceAdapter
     * @throws ServiceNotAvailableException
     */
    public function getMockingObject($url)
    {
        $videoParser = new VideoServiceMatcher();
        $youtubeVideo = $videoParser->parse($url);

        return $youtubeVideo;
    }
}

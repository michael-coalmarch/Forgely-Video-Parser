<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 31/08/2015
 * Time: 21:54
 */

namespace Coalmarch\Test\Detector;

use PHPUnit_Framework_TestCase;
use Coalmarch\Container\Factory\ServicesContainerFactory;
use Coalmarch\Matcher\VideoServiceMatcher;
use Coalmarch\Exception\ServiceNotAvailableException;

class VideoServiceMatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider videoUrlProvider
     * @param $url
     * @param $expectedServiceName
     * @throws ServiceNotAvailableException
     */
    public function testCanParseUrl($url, $expectedServiceName)
    {
        $detector = new VideoServiceMatcher();
        $video = $detector->parse($url);
        $this->assertInstanceOf($expectedServiceName, $video);
    }

    /**
     * @return array
     */
    public function videoUrlProvider()
    {

        return array(
            'Normal Youtube URL' => array(
                'https://www.youtube.com/watch?v=mWRsgZuwf_8',
                '\\Coalmarch\\Adapter\\Youtube\\YoutubeServiceAdapter',
            ),
            'Short Youtube URL' => array(
                'https://youtu.be/JMLBOKVfHaA',
                'Coalmarch\\Adapter\\Youtube\\YoutubeServiceAdapter',
            ),
            'Embed Youtube URL' => array(
                '<iframe width="420" height="315" src="https://www.youtube.com/embed/vwp9JkaESdg" frameborder="0" allowfullscreen></iframe>',
                '\\Coalmarch\\Adapter\\Youtube\\YoutubeServiceAdapter',
            ),
            'Common Vimeo URL' => array(
                'https://vimeo.com/137781541',
                '\\Coalmarch\\Adapter\\Vimeo\\VimeoServiceAdapter',
            ),
            'Commom Dailymotion URL' => array(
                'http://www.dailymotion.com/video/x332a71_que-categoria-jogador-lucas-lima-faz-golaco-em-treino-do-santos_sport',
                '\\Coalmarch\\Adapter\\Dailymotion\\DailymotionServiceAdapter',
            ),
            'Commom Facebook Video URL' => array(
                'https://www.facebook.com/RantPets/videos/583336855137988/',
                '\\Coalmarch\\Adapter\\Facebook\\FacebookServiceAdapter',
            )
        );
    }

    /**
     * @throws ServiceNotAvailableException
     * @dataProvider invalidVideoUrlProvider
     */
    public function testThrowsExceptionOnInvalidUrl($url)
    {
        $detector = new VideoServiceMatcher();
        $this->setExpectedException('\\Coalmarch\\Exception\\ServiceNotAvailableException');
        $video = $detector->parse($url);
    }

    /**
     * @return array
     */
    public function invalidVideoUrlProvider()
    {
        return array(
            array(
                'http://tvuol.uol.com.br/video/dirigindo-pelo-mundo-de-final-fantasy-xv-0402CC9B3764E4A95326',
            ),
            array(
                'https://www.google.com.br/',
            ),
            array(
                'https://www.youtube.com/',
            ),
        );
    }

    /**
     * @dataProvider videoUrlProvider
     * @param $url
     * @throws ServiceNotAvailableException
     */
    public function testServiceDetectorDontReparseSameUrl($url)
    {
        $detector = new VideoServiceMatcher();
        $video = $detector->parse($url);

        $this->assertSame($video, $detector->parse($url));
    }

    /**
     * Tests container getter
     */
    public function testServiceContainerGetter()
    {
        $detector = new VideoServiceMatcher();
        $this->assertInstanceOf('Coalmarch\\Container\\ServicesContainer', $detector->getServiceContainer());
    }

    /**
     * Tests container setter
     */
    public function testServiceContainerSetter()
    {
        $detector = new VideoServiceMatcher();
        $serviceContainer = ServicesContainerFactory::createNewServiceMatcher();
        $detector->setServiceContainer($serviceContainer);
        $this->assertSame($serviceContainer, $detector->getServiceContainer());
    }

}

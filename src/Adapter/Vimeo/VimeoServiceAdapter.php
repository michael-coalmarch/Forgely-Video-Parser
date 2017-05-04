<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 29/08/2015
 * Time: 14:56.
 */
namespace Coalmarch\Adapter\Vimeo;

use Coalmarch\Adapter\AbstractServiceAdapter;
use Coalmarch\Exception\InvalidThumbnailSizeException;
use Coalmarch\Exception\ServiceApiNotAvailable;
use Coalmarch\Renderer\EmbedRendererInterface;

class VimeoServiceAdapter extends AbstractServiceAdapter
{
    const THUMBNAIL_SMALL = 'thumbnail_small';
    const THUMBNAIL_MEDIUM = 'thumbnail_medium';
    const THUMBNAIL_LARGE = 'thumbnail_large';

    /**
     * @var string
     */
    public $title;
    public $pat;
    public $u;
    /**
     * @var string
     */
    public $description;

    /**
     * @var array
     */
    public $thumbnails;

    /**
     * @param string $url
     * @param string $pattern
     * @param EmbedRendererInterface $renderer
     */
    public function __construct($url, $pattern, EmbedRendererInterface $renderer)
    {
        $videoId = $this->getVideoIdByPattern($url, $pattern);
        $this->setVideoId($videoId);
        $this->pat=$pattern;
        $this->u = $url;
        $videoData = $this->getVideoDataFromServiceApi();

//        $this->setThumbnails(array(
//            self::THUMBNAIL_SMALL => $videoData[self::THUMBNAIL_SMALL],
//            self::THUMBNAIL_MEDIUM => $videoData[self::THUMBNAIL_MEDIUM],
//            self::THUMBNAIL_LARGE => $videoData[self::THUMBNAIL_LARGE],
//        ));

        $this->setTitle('Vimeo');
        $this->setDescription('Description');

        return parent::__construct($url, $pattern, $renderer);
    }

    /**
     * Returns the service name (ie: "Youtube" or "Vimeo").
     *
     * @return string
     */
    public function getServiceName()
    {
        return 'Vimeo';
    }

    /**
     * Returns if the service has a thumbnail image.
     *
     * @return bool
     */
    public function hasThumbnail()
    {
        return false == empty($this->thumbnails);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param array $thumbnails
     */
    private function setThumbnails(array $thumbnails)
    {
        foreach ($thumbnails as $key => $thumbnail) {
            $this->thumbnails[$key] = parse_url($thumbnail);
        }
    }

    /**
     * @param string $size
     *
     * @return string
     *
     * @throws InvalidThumbnailSizeException
     */
    public function getThumbnail($size, $secure = false)
    {
        if (false == in_array($size, $this->getThumbNailSizes())) {
            throw new InvalidThumbnailSizeException();
        }

        return $this->getScheme($secure) . '://' . $this->thumbnails[$size]['host'] . $this->thumbnails[$size]['path'];
    }

    /**
     * @param bool $autoplay
     *
     * @return string
     */
    public function getEmbedUrl($autoplay = false, $secure = false)
    {
        return $this->getScheme($secure) . '://player.vimeo.com/video/' . $this->getVideoId() . ($autoplay ? '?autoplay=1' : '');
    }

    /**
     * Returns all thumbnails available sizes.
     *
     * @return array
     */
    public function getThumbNailSizes()
    {
        return array(
            self::THUMBNAIL_SMALL,
            self::THUMBNAIL_MEDIUM,
            self::THUMBNAIL_LARGE,
        );
    }

    /**
     * Returns the small thumbnail's url.
     *
     * @param bool $secure
     * @return string
     * @throws InvalidThumbnailSizeException
     */
    public function getSmallThumbnail($secure = false)
    {
        return $this->getThumbnail(self::THUMBNAIL_SMALL,$secure);
    }

    /**
     * Returns the medium thumbnail's url.
     *
     * @param bool $secure
     * @return string
     * @throws InvalidThumbnailSizeException
     */
    public function getMediumThumbnail($secure = false)
    {
        return $this->getThumbnail(self::THUMBNAIL_MEDIUM,$secure);
    }

    /**
     * Returns the large thumbnail's url.
     *
     * @param bool $secure
     * @param $secure
     * @return string
     * @throws InvalidThumbnailSizeException
     */
    public function getLargeThumbnail($secure = false)
    {
        return $this->getThumbnail(self::THUMBNAIL_LARGE,$secure);
    }

    /**
     * Returns the largest thumnbnaail's url.
     *
     * @param bool $secure
     * @param $secure
     * @return string
     * @throws InvalidThumbnailSizeException
     */
    public function getLargestThumbnail($secure = false)
    {
        return $this->getThumbnail(self::THUMBNAIL_LARGE,$secure);
    }

    /**
     * @return bool
     */
    public function isEmbeddable()
    {
        return true;
    }

    /**
     * @param string $url
     * @param string $pattern
     *
     * @return int
     */
    private function getVideoIdByPattern($url, $pattern)
    {
        $match = array();
        preg_match($pattern, $url, $match);
        $videoId = $match[2];

        return $videoId;
    }

    /**
     * Uses the Vimeo video API to get video info.
     *
     * If the Vimeo url entered is private or invalid, the function
     * will force data to enable rendering
     * @todo add client side error reporting of private video
     * @todo make this better by using guzzle
     *
     * @return array
     *
     * @throws ServiceApiNotAvailable
     */
    private function getVideoDataFromServiceApi()
    {
        $contents = @file_get_contents('http://vimeo.com/api/v2/video/' . $this->getVideoId() . '.php');
        if($contents == false){
            $vidData = array(
                'id'=>$this->getVideoIdByPattern($this->u,$this->pat),
                'url'=>$this->u,
                'width'=>1280,
                'height'=>720
            );

            $vidDataJson = json_encode($vidData);
            return $vidDataJson;
        }else{
            $hash = unserialize($contents);

            return reset($hash);
        }
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-10 15:14
 */
namespace Notadd\Foundation\Image;

/**
 * Class AbstractShape.
 */
abstract class AbstractShape
{
    /**
     * Background color of shape
     *
     * @var string
     */
    public $background;

    /**
     * Border color of current shape
     *
     * @var string
     */
    public $border_color;

    /**
     * Border width of shape
     *
     * @var int
     */
    public $border_width = 0;

    /**
     * Draws shape to given image on given position
     *
     * @param Image $image
     * @param int   $posx
     * @param int   $posy
     *
     * @return bool
     */
    abstract public function applyToImage(Image $image, $posx = 0, $posy = 0);

    /**
     * Set text to be written
     *
     * @param $color
     */
    public function background($color)
    {
        $this->background = $color;
    }

    /**
     * Set border width and color of current shape
     *
     * @param int    $width
     * @param string $color
     */
    public function border($width, $color = null)
    {
        $this->border_width = is_numeric($width) ? intval($width) : 0;
        $this->border_color = is_null($color) ? '#000000' : $color;
    }

    /**
     * Determines if current shape has border
     *
     * @return bool
     */
    public function hasBorder()
    {
        return $this->border_width >= 1;
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-10 19:10
 */
namespace Notadd\Foundation\Image\Imagick\Commands;

/**
 * Class WidenCommand.
 */
class WidenCommand extends ResizeCommand
{
    /**
     * @param \Notadd\Foundation\Image\Image $image
     *
     * @return bool
     */
    public function execute($image)
    {
        $width = $this->argument(0)->type('digit')->required()->value();
        $additionalConstraints = $this->argument(1)->type('closure')->value();
        $this->arguments[0] = $width;
        $this->arguments[1] = null;
        $this->arguments[2] = function ($constraint) use ($additionalConstraints) {
            $constraint->aspectRatio();
            if (is_callable($additionalConstraints)) {
                $additionalConstraints($constraint);
            }
        };

        return parent::execute($image);
    }
}

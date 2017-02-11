<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 15:17
 */
namespace Notadd\Foundation\Image;

/**
 * Class File.
 */
class File
{
    /**
     * Mime type
     *
     * @var string
     */
    public $mime;

    /**
     * Name of directory path
     *
     * @var string
     */
    public $dirname;

    /**
     * Basename of current file
     *
     * @var string
     */
    public $basename;

    /**
     * File extension of current file
     *
     * @var string
     */
    public $extension;

    /**
     * File name of current file
     *
     * @var string
     */
    public $filename;

    /**
     * Sets all instance properties from given path
     *
     * @param string $path
     *
     * @return $this
     */
    public function setFileInfoFromPath($path)
    {
        $info = pathinfo($path);
        $this->dirname = array_key_exists('dirname', $info) ? $info['dirname'] : null;
        $this->basename = array_key_exists('basename', $info) ? $info['basename'] : null;
        $this->extension = array_key_exists('extension', $info) ? $info['extension'] : null;
        $this->filename = array_key_exists('filename', $info) ? $info['filename'] : null;
        if (file_exists($path) && is_file($path)) {
            $this->mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
        }

        return $this;
    }

    /**
     * Get file size
     *
     * @return mixed
     */
    public function filesize()
    {
        $path = $this->basePath();
        if (file_exists($path) && is_file($path)) {
            return filesize($path);
        }

        return false;
    }

    /**
     * Get fully qualified path
     *
     * @return string
     */
    public function basePath()
    {
        if ($this->dirname && $this->basename) {
            return $this->dirname . '/' . $this->basename;
        }

        return null;
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-22 12:19
 */
namespace Notadd\Foundation\Session;

use Illuminate\Session\SessionServiceProvider as IlluminateSessionServiceProvider;

/**
 * Class SessionServiceProvider.
 */
class SessionServiceProvider extends IlluminateSessionServiceProvider
{
    /**
     * Register for service provider.
     */
    public function register()
    {
        parent::register();
    }
}

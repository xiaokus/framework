<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-08 17:02
 */
namespace Notadd\Foundation\Setting\Listeners;

use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;
use Notadd\Foundation\Setting\Controllers\SettingController;

/**
 * Class RouteRegister.
 */
class RouteRegister extends AbstractRouteRegister
{
    /**
     * Handle Route Register.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api/setting'], function () {
            $this->router->post('all', SettingController::class . '@all');
            $this->router->post('get', SettingController::class . '@get');
            $this->router->post('set', SettingController::class . '@set');
        });
    }
}

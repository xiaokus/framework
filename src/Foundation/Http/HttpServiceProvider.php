<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-27 14:59
 */
namespace Notadd\Foundation\Http;
use Notadd\Foundation\Abstracts\ServiceProvider;
use Notadd\Foundation\Http\Listeners\RouteRegistrar;
use Notadd\Foundation\Http\Middlewares\AuthenticateWithSession;
use Notadd\Foundation\Http\Middlewares\RememberFromCookie;
use Notadd\Foundation\Member\MemberServiceProvider;
/**
 * Class HttpServiceProvider
 * @package Notadd\Foundation\Http
 */
class HttpServiceProvider extends ServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        $this->app->register(MemberServiceProvider::class);
        $this->events->subscribe(RouteRegistrar::class);
        $this->router->middlewareGroup('web', [
            RememberFromCookie::class,
            AuthenticateWithSession::class
        ]);
        $this->loadViewsFrom(resource_path('views/admin'), 'admin');
        $this->loadViewsFrom(resource_path('views/theme'), 'theme');
    }
}
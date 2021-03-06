<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 15:24
 */
namespace Notadd\Foundation\Routing\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Support\Str;
use Notadd\Foundation\Validation\ValidatesRequests;

/**
 * Class Controller.
 */
abstract class Controller extends IlluminateController
{
    use ValidatesRequests;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var array
     */
    protected $middleware = [];

    /**
     * @var \Illuminate\Routing\Redirector
     */
    protected $redirector;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->container = $this->getContainer();
        $this->events = $this->container->make('events');
        $this->redirector = $this->container->make('redirect');
        $this->request = $this->container->make('request');
        $this->view = $this->container->make('view');
    }

    /**
     * Get a command from console instance.
     *
     * @param string $name
     *
     * @return \Notadd\Foundation\Console\Abstracts\Command|\Symfony\Component\Console\Command\Command
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getCommand($name)
    {
        return $this->getConsole()->get($name);
    }

    /**
     * Get configuration instance.
     *
     * @return \Notadd\Foundation\Configuration\Repository
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getConfig()
    {
        return $this->container->make('config');
    }

    /**
     * Get console instance.
     *
     * @return \Illuminate\Contracts\Console\Kernel|\Notadd\Foundation\Console\Application
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getConsole()
    {
        $kernel = $this->container->make(Kernel::class);
        $kernel->bootstrap();

        return $kernel->getArtisan();
    }

    /**
     * Get IoC Container.
     *
     * @return \Illuminate\Container\Container
     */
    public function getContainer()
    {
        return Container::getInstance();
    }

    /**
     * Get logger instance.
     *
     * @return \Psr\Log\LoggerInterface
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getLogger()
    {
        return $this->container->make('log');
    }

    /**
     * Get mailer instance.
     *
     * @return \Illuminate\Mail\Mailer
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getMailer()
    {
        return $this->container->make('mailer');
    }

    /**
     * Get session instance.
     *
     * @return \Illuminate\Session\Store
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getSession()
    {
        return $this->container->make('session');
    }

    /**
     * Get setting instance.
     *
     * @return \Notadd\Foundation\Setting\Contracts\SettingsRepository
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getSetting()
    {
        return $this->container->make('setting');
    }

    /**
     * Share variable with view.
     *
     * @param      $key
     * @param null $value
     */
    protected function share($key, $value = null)
    {
        $this->view->share($key, $value);
    }

    /**
     * Share variable with view.
     *
     * @param       $template
     * @param array $data
     * @param array $mergeData
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function view($template, array $data = [], $mergeData = [])
    {
        if (Str::contains($template, '::')) {
            return $this->view->make($template, $data, $mergeData);
        } else {
            return $this->view->make('theme::' . $template, $data, $mergeData);
        }
    }
}

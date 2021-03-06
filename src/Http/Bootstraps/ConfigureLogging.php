<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 10:58
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;

/**
 * Class ConfigureLogging.
 */
class ConfigureLogging
{
    /**
     * Bootstrap the given application.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $application
     *
     * @return void
     */
    public function bootstrap(Application $application)
    {
        $log = $this->registerLogger($application);
        if ($application->hasMonologConfigurator()) {
            call_user_func($application->getMonologConfigurator(), $log->getMonolog());
        } else {
            $this->configureHandlers($application, $log);
        }
    }

    /**
     * Register the logger instance in the container.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return \Illuminate\Log\Writer
     */
    protected function registerLogger(Application $app)
    {
        $app->instance('log', $log = new Writer(new Monolog($app->environment()), $app['events']));

        return $log;
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Log\Writer                       $log
     *
     * @return void
     */
    protected function configureHandlers(Application $app, Writer $log)
    {
        $method = 'configure' . ucfirst($app['config']['app.log']) . 'Handler';
        $this->{$method}($app, $log);
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $app
     * @param \Illuminate\Log\Writer                                                      $log
     *
     * @return void
     */
    protected function configureSingleHandler(Application $app, Writer $log)
    {
        $log->useFiles($app->storagePath() . '/logs/notadd.log', $app->make('config')->get('app.log_level', 'debug'));
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $app
     * @param \Illuminate\Log\Writer                                                      $log
     *
     * @return void
     */
    protected function configureDailyHandler(Application $app, Writer $log)
    {
        $config = $app->make('config');
        $maxFiles = $config->get('app.log_max_files');
        $log->useDailyFiles($app->storagePath() . '/logs/notadd.log', is_null($maxFiles) ? 5 : $maxFiles,
            $config->get('app.log_level', 'debug'));
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $app
     * @param \Illuminate\Log\Writer                                                      $log
     *
     * @return void
     */
    protected function configureSyslogHandler(Application $app, Writer $log)
    {
        $log->useSyslog('notadd', $app->make('config')->get('app.log_level', 'debug'));
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $app
     * @param \Illuminate\Log\Writer                                                      $log
     *
     * @return void
     */
    protected function configureErrorlogHandler(Application $app, Writer $log)
    {
        $log->useErrorLog($app->make('config')->get('app.log_level', 'debug'));
    }
}
